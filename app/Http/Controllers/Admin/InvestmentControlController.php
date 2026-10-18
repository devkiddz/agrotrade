<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class InvestmentControlController extends Controller
{
    private function ready(): bool
    {
        return Schema::hasTable('agrotrade_investment_controls') && Schema::hasTable('agrotrade_investment_control_events');
    }

    public function index()
    {
        abort_unless($this->ready(), 503, 'Investment controls migration is pending.');
        // Phase 1C focused investment lookup (read-only).
        $type = request()->query('type');
        $id = request()->query('id');
        if ($type !== null || $id !== null) {
            abort_unless(in_array($type, ['legacy', 'modern'], true) && is_string($id) && ctype_digit($id) && (int) $id > 0, 404);
            $targetTable = $type === 'legacy' ? 'investments' : 'user_plans';
            abort_unless(DB::table($targetTable)->where('id', $id)->exists(), 404);
        }
        $legacy = DB::table('investments')->orderByDesc('id')->limit(100)->get();
        $modern = DB::table('user_plans')->orderByDesc('id')->limit(100)->get();
        if ($type === 'legacy') {
            $legacy = DB::table('investments')->where('id', $id)->get();
            $modern = collect();
        } elseif ($type === 'modern') {
            $legacy = collect();
            $modern = DB::table('user_plans')->where('id', $id)->get();
        }
        $controls = DB::table('agrotrade_investment_controls')->get()->keyBy(function ($row) {
            return $row->investment_type . ':' . $row->investment_id;
        });
        $events = DB::table('agrotrade_investment_control_events')->orderByDesc('id')->limit(50)->get();
        return view('admin.investment-controls.index', compact('legacy', 'modern', 'controls', 'events'));
    }

    public function update(Request $request, string $type, string $id)
    {
        abort_unless($this->ready(), 503, 'Investment controls migration is pending.');
        abort_unless(Auth::guard('admin')->check(), 403);
        $data = $request->validate([
            'action' => ['required', Rule::in(['pause', 'resume', 'suspend', 'reinstate', 'flag', 'clear_flag'])],
            'reason' => ['required', 'string', 'min:5', 'max:1000'],
        ]);
        $table = $type === 'legacy' ? 'investments' : 'user_plans';
        abort_unless(in_array($type, ['legacy', 'modern'], true) && ctype_digit($id) && (int)$id > 0, 404);
        $actor = Auth::guard('admin')->id();
        DB::transaction(function () use ($table, $type, $id, $data, $actor) {
            // Same investment row is locked by ROI processors, ensuring ordering.
            $investment = DB::table($table)->where('id', $id)->lockForUpdate()->first();
            abort_unless($investment, 404);
            $prior = DB::table('agrotrade_investment_controls')->where('investment_type', $type)
                ->where('investment_id', $id)->lockForUpdate()->first();
            $current = $prior ? $prior->state : 'active';
            $transitions = [
                'active' => ['pause' => 'paused', 'suspend' => 'suspended', 'flag' => 'flagged'],
                'paused' => ['resume' => 'active', 'suspend' => 'suspended', 'flag' => 'flagged'],
                'suspended' => ['reinstate' => 'active', 'flag' => 'flagged'],
                'flagged' => ['clear_flag' => 'active', 'suspend' => 'suspended'],
            ];
            $next = $transitions[$current][$data['action']] ?? null;
            if ($next === null) {
                throw \Illuminate\Validation\ValidationException::withMessages(['action' => 'Invalid state transition from ' . $current]);
            }
            $values = ['state' => $next, 'reason' => $data['reason'], 'updated_by' => $actor, 'updated_at' => now()];
            if ($prior) {
                DB::table('agrotrade_investment_controls')->where('id', $prior->id)->update($values);
            } else {
                DB::table('agrotrade_investment_controls')->insert(array_merge($values, [
                    'investment_type' => $type, 'investment_id' => $id, 'created_at' => now(),
                ]));
            }
            DB::table('agrotrade_investment_control_events')->insert([
                'investment_type' => $type, 'investment_id' => $id, 'admin_id' => $actor,
                'action' => $data['action'], 'from_state' => $current, 'to_state' => $next,
                'reason' => $data['reason'], 'created_at' => now(),
            ]);
        }, 3);
        return redirect()->route('admin.investment-controls.index')->with('success', 'Investment control updated.');
    }
}
