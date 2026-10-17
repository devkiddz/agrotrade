<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CryptoAccount;
use Illuminate\Support\Facades\Auth;
use App\Models\SettingsCont;
use App\Models\Settings;
use App\Models\User;
use App\Models\Instrument;
use Illuminate\Support\Facades\DB;
use App\Models\CryptoRecord;
use App\Traits\Apitrait;
use App\Traits\TemplateTrait;

class ExchangeController extends Controller
{
    use Apitrait, TemplateTrait;

    public function assetview()
    {
        $settings = SettingsCont::where('id', '1')->first();
        if ($settings->use_crypto_feature == 'false') {
            abort(404);
        }

        try {
            // Check if Instrument table exists and has records
            try {
                if (!\Schema::hasTable('instruments')) {
                    \Log::warning("Instruments table does not exist. Creating it.");
                    \Schema::create('instruments', function ($table) {
                        $table->id();
                        $table->string('symbol')->nullable();
                        $table->string('name')->nullable();
                        $table->string('type')->default('crypto');
                        $table->decimal('price', 18, 8)->nullable();
                        $table->timestamps();
                    });
                }
            } catch (\Exception $e) {
                \Log::error("Error checking/creating instrument table: " . $e->getMessage());
            }

            // Ensure basic crypto instruments exist in database
            $this->ensureBasicCryptoInstruments();

        } catch (\Exception $e) {
            \Log::error("Error in asset view: " . $e->getMessage());
        }

        // Make sure we have a crypto account for the user
        $cbalance = CryptoAccount::where('user_id', Auth::user()->id)->first();
        if (!$cbalance) {
            // Create a default account if it doesn't exist
            $cbalance = new CryptoAccount();
            $cbalance->user_id = Auth::user()->id;
            $cbalance->btc = 0;
            $cbalance->eth = 0;
            $cbalance->usdt = 0;
            $cbalance->ltc = 0;
            $cbalance->xrp = 0;
            $cbalance->link = 0;
            $cbalance->bnb = 0;
            $cbalance->ada = 0;
            $cbalance->aave = 0;
            $cbalance->bch = 0;
            $cbalance->xlm = 0;
            $cbalance->save();
        }

        return view("user.asset", [
            'title' =>  'Exchange currency',
            'cbalance' => $cbalance,
        ]);
    }

    /**
     * Ensure basic crypto instruments exist in the database with default prices
     */
    private function ensureBasicCryptoInstruments()
    {
        try {
            $now = now();
            $basicCryptos = [
                [
                    'symbol' => 'BTC/USD',
                    'name' => 'Bitcoin',
                    'type' => 'crypto',
                    'price' => 45000.00
                ],
                [
                    'symbol' => 'ETH/USD',
                    'name' => 'Ethereum',
                    'type' => 'crypto',
                    'price' => 3000.00
                ],
                [
                    'symbol' => 'USDT/USD',
                    'name' => 'Tether',
                    'type' => 'crypto',
                    'price' => 1.00
                ],
                [
                    'symbol' => 'BNB/USD',
                    'name' => 'Binance Coin',
                    'type' => 'crypto',
                    'price' => 300.00
                ],
                [
                    'symbol' => 'ADA/USD',
                    'name' => 'Cardano',
                    'type' => 'crypto',
                    'price' => 0.50
                ],
                [
                    'symbol' => 'XRP/USD',
                    'name' => 'Ripple',
                    'type' => 'crypto',
                    'price' => 0.60
                ],
                [
                    'symbol' => 'LTC/USD',
                    'name' => 'Litecoin',
                    'type' => 'crypto',
                    'price' => 100.00
                ],
                [
                    'symbol' => 'BCH/USD',
                    'name' => 'Bitcoin Cash',
                    'type' => 'crypto',
                    'price' => 250.00
                ],
                [
                    'symbol' => 'LINK/USD',
                    'name' => 'Chainlink',
                    'type' => 'crypto',
                    'price' => 15.00
                ],
                [
                    'symbol' => 'XLM/USD',
                    'name' => 'Stellar',
                    'type' => 'crypto',
                    'price' => 0.10
                ],
                [
                    'symbol' => 'AAVE/USD',
                    'name' => 'Aave',
                    'type' => 'crypto',
                    'price' => 100.00
                ]
            ];

            foreach ($basicCryptos as $crypto) {
                // Try to find the instrument first
                $instrument = Instrument::where('symbol', $crypto['symbol'])->first();

                if ($instrument) {
                    // Update the existing instrument if price is missing or zero
                    if (empty($instrument->price) || $instrument->price <= 0) {
                        $instrument->price = $crypto['price'];
                        $instrument->updated_at = $now;
                        $instrument->save();
                        \Log::info("Updated price for {$crypto['symbol']} to {$crypto['price']}");
                    }
                } else {
                    // Create a new instrument if it doesn't exist
                    $crypto['created_at'] = $now;
                    $crypto['updated_at'] = $now;
                    Instrument::create($crypto);
                    \Log::info("Created new instrument {$crypto['symbol']} with price {$crypto['price']}");
                }
            }

            // Also ensure we have plain symbol records which are easier to match
            $simpleSymbols = [
                'BTC' => 45000.00,
                'ETH' => 3000.00,
                'USDT' => 1.00,
                'BNB' => 300.00,
                'ADA' => 0.50,
                'XRP' => 0.60,
                'LTC' => 100.00,
                'BCH' => 250.00,
                'LINK' => 15.00,
                'XLM' => 0.10,
                'AAVE' => 100.00
            ];

            foreach ($simpleSymbols as $symbol => $price) {
                Instrument::firstOrCreate(
                    ['symbol' => $symbol, 'type' => 'crypto'],
                    [
                        'name' => $symbol,
                        'price' => $price,
                        'type' => 'crypto',
                        'created_at' => $now,
                        'updated_at' => $now
                    ]
                );
            }
        } catch (\Exception $e) {
            // If database isn't available, skip seeding
            \Log::warning('Could not seed crypto instruments: ' . $e->getMessage());
        }
    }

    public function history()
    {
        return view("user.crypto-transaction", [
            'title' => 'Swapping History',
            'transactions' => DB::table('crypto_records')->orderByDesc('id')->paginate(10),
        ]);
    }

    public function getprice($base, $quote, $amount)
    {
        try {
            // Log the incoming request
            \Log::info("Price calculation request: {$base} to {$quote}, amount: {$amount}");

            // Ensure database has crypto price data before processing
            $this->ensureBasicCryptoInstruments();

            $settings = SettingsCont::where('id', '1')->first();
            $fee_percentage = $settings->fee ?? 0;
            $pluscharge = $amount * $fee_percentage / 100;
            $amount_after_fee = $amount - $pluscharge;

            // Handle same currency exchange
            if ($base === $quote) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Source and destination currencies cannot be the same'
                ]);
            }

            $base = strtolower($base);
            $quote = strtolower($quote);

            // Handle USD to USDT and USDT to USD (1:1 ratio)
            if (($base == "usd" && $quote == "usdt") || ($base == "usdt" && $quote == "usd")) {
                $prices = round($amount_after_fee, 8);
            }
            // Handle USD as quote currency
            elseif ($quote == "usd") {
                $rate = $this->get_rate($base, 'usd');
                if ($rate <= 0) {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Unable to get exchange rate for ' . strtoupper($base) . '. Please try again later.'
                    ]);
                }
                $mainbal = $amount_after_fee * $rate;
                $prices = round($mainbal, 8);
            }
            // Handle USD as base currency
            elseif ($base == "usd") {
                $rate = $this->get_rate($quote, 'usd');
                if ($rate <= 0) {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Unable to get exchange rate for ' . strtoupper($quote) . '. Please try again later.'
                    ]);
                }
                $mainbal = $amount_after_fee / $rate;
                $prices = round($mainbal, 8);
            }
            // Handle USDT as quote currency
            elseif ($quote == "usdt") {
                $rate = $this->get_rate($base, 'usd');
                if ($rate <= 0) {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Unable to get exchange rate for ' . strtoupper($base) . '. Please try again later.'
                    ]);
                }
                $prices = round($amount_after_fee * $rate, 8);
            }
            // Handle USDT as base currency
            elseif ($base == "usdt") {
                $rate = $this->get_rate($quote, 'usd');
                if ($rate <= 0) {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Unable to get exchange rate for ' . strtoupper($quote) . '. Please try again later.'
                    ]);
                }
                $mainbal = $amount_after_fee / $rate;
                $prices = round($mainbal, 8);
            }
            // Handle crypto to crypto conversion
            else {
                $rate1 = $this->get_rate($base, 'usd');
                $rate2 = $this->get_rate($quote, 'usd');

                if ($rate1 <= 0 || $rate2 <= 0) {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Unable to get exchange rates. Please try again later.'
                    ]);
                }

                $real_rate = $rate1 / $rate2;
                $mainbal = $amount_after_fee * $real_rate;
                $prices = round($mainbal, 8);
            }

            return response()->json([
                'status' => 200,
                'data' => $prices,
                'fee' => round($pluscharge, 8),
                'fee_percentage' => $fee_percentage,
                'exchange_rate' => isset($real_rate) ? round($real_rate, 8) : null,
                'price_source' => $this->priceSource // Include source of price data
            ]);

        } catch (\Exception $e) {
            \Log::error('Exchange price calculation error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());

            // Default fallback prices to ensure the exchange always works
            $fallbackPrices = [
                'btc' => 45000.00,
                'eth' => 3000.00,
                'usdt' => 1.00,
                'bnb' => 300.00,
                'ada' => 0.50,
                'xrp' => 0.60,
                'ltc' => 100.00,
                'bch' => 250.00,
                'link' => 15.00,
                'xlm' => 0.10,
                'aave' => 100.00,
                'usd' => 1.00
            ];

            // Calculate a fallback price to ensure functionality
            $base = strtolower($base);
            $quote = strtolower($quote);

            $settings = SettingsCont::where('id', '1')->first();
            $fee_percentage = $settings->fee ?? 0;
            $pluscharge = $amount * $fee_percentage / 100;
            $amount_after_fee = $amount - $pluscharge;

            $baseRate = $fallbackPrices[$base] ?? 1.0;
            $quoteRate = $fallbackPrices[$quote] ?? 1.0;

            // Simple direct conversion
            if ($quote == 'usd') {
                $prices = round($amount_after_fee * $baseRate, 8);
            } elseif ($base == 'usd') {
                $prices = round($amount_after_fee / $quoteRate, 8);
            } else {
                $prices = round(($amount_after_fee * $baseRate) / $quoteRate, 8);
            }

            \Log::info("Using fallback calculation: {$base}({$baseRate}) to {$quote}({$quoteRate}): {$amount} → {$prices}");

            return response()->json([
                'status' => 200,  // Return 200 to ensure the UI works
                'data' => $prices,
                'fee' => round($pluscharge, 8),
                'fee_percentage' => $fee_percentage,
                'price_source' => 'emergency_fallback',
                'message' => 'Using fallback exchange rate'
            ]);
        }
    }


    public function exchange(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'source' => 'required|string',
                'destination' => 'required|string',
                'amount' => 'required|numeric|min:0.00000001',
                'quantity' => 'required|numeric|min:0'
            ]);

            // Check if source and destination are the same
            if ($request->source === $request->destination) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Source and destination currencies cannot be the same'
                ]);
            }

            $cryptobalances = CryptoAccount::where('user_id', Auth::user()->id)->first();
            $user = User::find(Auth::user()->id);
            $acntbal = $user->account_bal;
            $src = $request->source;
            $dest = $request->destination;

            // Start database transaction
            DB::beginTransaction();

            // Handle USD as source currency
            if ($request->source == 'usd') {
                if ($acntbal < $request->amount) {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Insufficient funds in your USD account. Available: ' . number_format($acntbal, 2)
                    ]);
                }

                // Deduct from USD balance
                $user->update(['account_bal' => $acntbal - $request->amount]);

                // Add to destination crypto account
                $this->updateCryptoBalance($user->id, $dest, $cryptobalances->$dest + $request->quantity);
            }
            // Handle USD as destination currency
            elseif ($request->destination == 'usd') {
                if ($cryptobalances->$src < $request->amount) {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Insufficient funds in your ' . strtoupper($src) . ' account. Available: ' . number_format($cryptobalances->$src, 8)
                    ]);
                }

                // Deduct from crypto balance
                $this->updateCryptoBalance($user->id, $src, $cryptobalances->$src - $request->amount);

                // Add to USD balance
                $user->update(['account_bal' => $acntbal + $request->quantity]);
            }
            // Handle crypto to crypto exchange
            else {
                if ($cryptobalances->$src < $request->amount) {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Insufficient funds in your ' . strtoupper($src) . ' account. Available: ' . number_format($cryptobalances->$src, 8)
                    ]);
                }

                // Update both crypto balances
                $this->updateCryptoBalance($user->id, $src, $cryptobalances->$src - $request->amount);
                $this->updateCryptoBalance($user->id, $dest, $cryptobalances->$dest + $request->quantity);
            }

            // Record the transaction
            CryptoRecord::create([
                'user_id' => $user->id,
                'source' => strtoupper($request->source),
                'dest' => strtoupper($request->destination),
                'amount' => $request->amount,
                'quantity' => $request->quantity,
                'status' => 'completed',
                'created_at' => now()
            ]);

            // Commit the transaction
            DB::commit();

            return response()->json([
                'status' => 200,
                'success' => 'Exchange completed successfully! Your balances are being refreshed.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status' => 400,
                'message' => 'Invalid input data: ' . implode(', ', $e->validator->errors()->all())
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Exchange error for user ' . Auth::id() . ': ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => 'Exchange failed. Please try again later.'
            ]);
        }
    }

    /**
     * Helper method to update crypto balance
     */
    private function updateCryptoBalance($userId, $currency, $newBalance)
    {
        return CryptoAccount::where('user_id', $userId)
            ->update([$currency => $newBalance]);
    }

    public function getBalance($coin)
    {
        $settings = Settings::where('id', '1')->first();
        $settingss = SettingsCont::where('id', '1')->first();
        $user = Auth::user();
        $acntbals = DB::table('crypto_accounts')->where('user_id', $user->id)->first();

        if (empty($acntbals->$coin)) {
            $balanc = 0;
        } else {
            $balanc = $acntbals->$coin;
        }

        $dollar = $this->get_rate($coin, 'usd');
        $mainbal = $balanc * $dollar;

        if ($settings->s_currency == 'USD') {
            $price = number_format(round($mainbal));
        } else {
            if (empty($settingss->currency_rate)) {
                $rate = 1;
            } else {
                $rate = $settingss->currency_rate;
            }

            $othercurr = $mainbal * $rate;
            $price = number_format(round($othercurr));
        }

        return response()->json([
            'data' => $price,
            'status' => 200
        ]);
    }
}
