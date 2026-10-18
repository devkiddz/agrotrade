<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\NewNotification;
use App\Models\Settings;
use App\Models\SettingsCont;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tp_Transaction;
use App\Traits\PingServer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class TransferController extends Controller
{
    use PingServer;

    public function transfertouser(Request $request)
    {
        // F2A: fail closed until the unique transfer-request migration is applied.
        if (!\Illuminate\Support\Facades\Schema::hasTable('agrotrade_transfer_requests')) {
            return response()->json(['status' => 419, 'message' => 'Transfers temporarily unavailable. Contact support.']);
        }

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email' => 'required|string|max:255',
            'password' => 'required|string',
            'amount' => ['required', 'regex:/^(?:[0-9]{1,9})(?:\.[0-9]{1,2})?$/'],
            'transfer_request_id' => 'required|uuid',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 419, 'message' => 'Invalid transfer details.']);
        }

        $senderId = Auth::id();
        if (!$senderId) {
            return response()->json(['status' => 419, 'message' => 'Please sign in again.']);
        }
        $sender = User::find($senderId);
        if (!$sender || !Hash::check($request->input('password'), $sender->password)) {
            return response()->json(['status' => 419, 'message' => 'Incorrect Password']);
        }

        $amountCents = (int) round(((float) $request->input('amount')) * 100);
        if ($amountCents <= 0) {
            return response()->json(['status' => 419, 'message' => 'Transfer amount must be positive.']);
        }
        $identifier = trim($request->input('email'));
        $matches = User::where('email', $identifier)->orWhere('username', $identifier)
            ->orderBy('id')->limit(2)->get();
        if ($matches->count() !== 1) {
            return response()->json(['status' => 419, 'message' => $matches->isEmpty()
                ? 'No user with this email address exist' : 'Recipient is ambiguous. Contact support.']);
        }
        $receiverId = $matches->first()->id;
        if ((int) $senderId === (int) $receiverId) {
            return response()->json(['status' => 419, 'message' => 'You cannot send funds to yourself']);
        }

        $settings = Settings::find(1);
        $feeSettings = SettingsCont::find(1);
        if (!$feeSettings || !is_numeric($feeSettings->transfer_charges)
            || (float) $feeSettings->transfer_charges < 0
            || (float) $feeSettings->transfer_charges > 100) {
            return response()->json(['status' => 419, 'message' => 'Transfer fees are unavailable. Contact support.']);
        }
        $feeCents = (int) round($amountCents * ((float) $feeSettings->transfer_charges) / 100);
        $debitCents = $amountCents + $feeCents;
        $requestId = strtolower($request->input('transfer_request_id'));
        $payloadHash = hash('sha256', implode('|', [$senderId, $receiverId, $amountCents]));
        $receipt = null;
        $alreadyCompleted = false;

        try {
            \Illuminate\Support\Facades\DB::transaction(function () use (
                $requestId, $senderId, $receiverId, $amountCents, $debitCents, $payloadHash,
                &$receipt, &$alreadyCompleted
            ) {
                // Unique primary key prevents two workers processing the same request ID.
                $prior = \Illuminate\Support\Facades\DB::table('agrotrade_transfer_requests')
                    ->where('id', $requestId)->lockForUpdate()->first();
                if ($prior) {
                    if ((int) $prior->sender_id !== (int) $senderId || $prior->payload_hash !== $payloadHash) {
                        throw new \DomainException('Transfer reference already used for different details.');
                    }
                    $alreadyCompleted = true;
                    return;
                }

                \Illuminate\Support\Facades\DB::table('agrotrade_transfer_requests')->insert([
                    'id' => $requestId, 'sender_id' => $senderId, 'receiver_id' => $receiverId,
                    'payload_hash' => $payloadHash, 'created_at' => now(), 'updated_at' => now(),
                ]);

                // Deterministic lock order reduces deadlock risk between opposing transfers.
                $ids = [(int) $senderId, (int) $receiverId];
                sort($ids, SORT_NUMERIC);
                $locked = User::whereIn('id', $ids)->orderBy('id')->lockForUpdate()->get()->keyBy('id');
                $from = $locked->get($senderId);
                $to = $locked->get($receiverId);
                if (!$from || !$to) {
                    throw new \DomainException('One of the accounts no longer exists.');
                }
                foreach ([$from, $to] as $account) {
                    if (!is_numeric($account->account_bal)
                        || !preg_match('/^-?[0-9]{1,13}(?:\.[0-9]{1,2})?$/', (string) $account->account_bal)) {
                        throw new \DomainException('Account balance requires administrator review.');
                    }
                }
                $fromCents = (int) round(((float) $from->account_bal) * 100);
                $toCents = (int) round(((float) $to->account_bal) * 100);
                if ($fromCents < $debitCents) {
                    throw new \DomainException('Insufficient Funds');
                }
                $from->account_bal = number_format(($fromCents - $debitCents) / 100, 2, '.', '');
                $to->account_bal = number_format(($toCents + $amountCents) / 100, 2, '.', '');
                $from->save();
                $to->save();
                Tp_Transaction::create([
                    'user' => $from->id, 'plan' => "Transfered to {$to->name}",
                    'amount' => number_format($amountCents / 100, 2, '.', ''), 'type' => 'Fund Transfer',
                ]);
                Tp_Transaction::create([
                    'user' => $to->id, 'plan' => "Received from {$from->name}",
                    'amount' => number_format($amountCents / 100, 2, '.', ''), 'type' => 'Fund Transfer',
                ]);
                $receipt = ['email' => $to->email, 'name' => $to->name,
                    'sender_name' => $from->name, 'sender_email' => $from->email,
                    'balance' => $to->account_bal];
            }, 3);
        } catch (\DomainException $e) {
            return response()->json(['status' => 419, 'message' => $e->getMessage()]);
        } catch (\Throwable $e) {
            // A concurrent identical request may have committed first.
            $prior = \Illuminate\Support\Facades\DB::table('agrotrade_transfer_requests')
                ->where('id', $requestId)->first();
            if ($prior && (int) $prior->sender_id === (int) $senderId
                && $prior->payload_hash === $payloadHash) {
                $alreadyCompleted = true;
            } else {
                \Log::error('Transfer transaction failed', ['sender_id' => $senderId,
                    'transfer_request_id' => $requestId, 'exception' => $e->getMessage()]);
                return response()->json(['status' => 419, 'message' => 'Transfer could not be completed. Please contact support.']);
            }
        }

        if (!$alreadyCompleted && $receipt) {
            $currency = $settings ? $settings->currency : '';
            $message = "You just received {$currency}" . number_format($amountCents / 100, 2, '.', '')
                . " from {$receipt['sender_name']} and your account balance is now {$currency}{$receipt['balance']}";
            try {
                Mail::to($receipt['email'])->send(new NewNotification($message, 'Credit Alert', $receipt['name']));
            } catch (\Throwable $e) {
                \Log::error('Transfer notification failed', ['transfer_request_id' => $requestId,
                    'error' => $e->getMessage()]);
            }
        }
        return response()->json(['status' => 200, 'message' => 'Transfer Completed, Refreshing page']);
    }


    public function renewSignalSub()
    {
        $user = User::find(Auth::user()->id);
        $response = $this->fetctApi('/subscription', [
            'id' => auth()->user()->id
        ]);
        $res = json_decode($response);
        $sub = $res->data;

        $responseSt = $this->fetctApi('/signal-settings');
        $info = json_decode($responseSt);
        $settings = $info->data->settings;

        if ($sub->subscription == 'Monthly') {
            $amount = $settings->signal_monthly_fee;
        } elseif ($sub->subscription == 'Quarterly') {
            $amount = $settings->signal_quartly_fee;
        } else {
            $amount = $settings->signal_yearly_fee;
        }

        if ($user->account_bal <  floatval($amount)) {
            return redirect()->back()->with('message', 'Your have insufficient funds in your account balance to perform this operation');
        }

        $renew =  $this->fetctApi('/renew-subscription', [
            'id' => $user->id,
        ], 'POST');

        if ($renew->successful()) {
            $user->account_bal = $user->account_bal - floatval($amount);
            $user->save();
            return redirect()->back()->with('success', 'Your subscription have been renewed successfully.');
        }
        return redirect()->back()->with('Something went wrong');
    }
}
