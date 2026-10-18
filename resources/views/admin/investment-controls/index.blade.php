@php
    $title = 'Investment Controls';
@endphp
@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
<style>
/* Scoped: never override shared admin shell or theme controller. */
.investment-controls { --ic-line:#e2e8f0;--ic-muted:#64748b;--ic-card:#ffffff;--ic-text:#1e293b;--ic-soft:#f8fafc;--ic-input:#ffffff;--ic-blue:#2563eb;color:var(--ic-text);padding:22px 0 52px;font-size:14px;line-height:1.5 }
.investment-controls.ic-dark { --ic-line:#34435a;--ic-muted:#adbed3;--ic-card:#172437;--ic-text:#f0f5fb;--ic-soft:#1d2d43;--ic-input:#101e30;--ic-blue:#65a3ff }
.investment-controls * { box-sizing:border-box }
.investment-controls .ic-heading { margin:0 0 22px }
.investment-controls .eyebrow { font-size:11px;letter-spacing:.12em;text-transform:uppercase;color:var(--ic-blue);font-weight:800;margin:0 0 7px }
.investment-controls h1 { font-size:clamp(24px,3vw,34px);line-height:1.2;margin:0 0 12px;color:var(--ic-text);font-weight:750 }
.investment-controls .intro { color:var(--ic-muted);max-width:920px;margin:0;line-height:1.7 }
.investment-controls .notice { display:flex;gap:12px;padding:14px 17px;border-radius:12px;border:1px solid var(--ic-line);background:var(--ic-soft);margin:22px 0;color:var(--ic-text) }
.investment-controls .notice .mark { color:var(--ic-blue);font-size:19px;line-height:1 }
.investment-controls .flash { padding:13px 17px;border-radius:11px;margin:18px 0;font-weight:600 }
.investment-controls .flash.success { background:#dcfce7;border:1px solid #86efac;color:#166534 }
.investment-controls .flash.error { background:#fee2e2;border:1px solid #fca5a5;color:#991b1b }
.investment-controls .panel { display:block;border:1px solid var(--ic-line);border-radius:15px;background:var(--ic-card);overflow:hidden;margin:22px 0;box-shadow:0 8px 26px rgba(0,0,0,.06);color:var(--ic-text) }
.investment-controls .panel-header { display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;padding:19px 22px;border-bottom:1px solid var(--ic-line);background:transparent;min-height:0 }
.investment-controls .panel-header h2 { font-size:18px;margin:0;color:var(--ic-text);font-weight:700 }
.investment-controls .panel-header p { margin:4px 0 0;color:var(--ic-muted);font-size:12px }
.investment-controls .pill { border:1px solid var(--ic-line);color:var(--ic-blue);background:var(--ic-soft);padding:5px 10px;border-radius:999px;font-size:11px;font-weight:700 }
.investment-controls .table-scroll { overflow-x:auto }
.investment-controls table { width:100%;border-collapse:collapse;min-width:840px;margin:0;background:transparent;color:var(--ic-text) }
.investment-controls th { color:var(--ic-muted);font-size:11px;text-transform:uppercase;letter-spacing:.06em;background:var(--ic-soft);text-align:left;font-weight:700;padding:13px 17px;white-space:nowrap;border:0 }
.investment-controls td { padding:14px 17px;border-top:1px solid var(--ic-line);vertical-align:middle;color:var(--ic-text) }
.investment-controls tbody tr:hover { background:var(--ic-soft) }
.investment-controls .mono { font-variant-numeric:tabular-nums;font-weight:700 }
.investment-controls .subtle { color:var(--ic-muted) }
.investment-controls .state { display:inline-flex;align-items:center;gap:7px;padding:5px 10px;border-radius:999px;border:1px solid var(--ic-line);background:var(--ic-soft);color:var(--ic-text);font-size:12px;font-weight:700;white-space:nowrap;text-transform:capitalize }
.investment-controls .state:before { content:'';width:7px;height:7px;border-radius:50%;background:#94a3b8 }
.investment-controls .state.active { background:#dcfce7;border-color:#86efac;color:#166534 }.investment-controls .state.active:before { background:#16a34a }
.investment-controls .state.paused,.investment-controls .state.flagged { background:#fef3c7;border-color:#fcd34d;color:#92400e }.investment-controls .state.paused:before,.investment-controls .state.flagged:before { background:#d97706 }
.investment-controls .state.suspended { background:#fee2e2;border-color:#fca5a5;color:#991b1b }.investment-controls .state.suspended:before { background:#dc2626 }
.investment-controls .action-form { display:flex;align-items:center;gap:9px;flex-wrap:wrap }
.investment-controls select,.investment-controls input,.investment-controls button { font:inherit;border-radius:8px;min-height:39px }
.investment-controls select,.investment-controls input { background:var(--ic-input);border:1px solid var(--ic-line);color:var(--ic-text);padding:8px 11px }
.investment-controls select { min-width:146px;cursor:pointer }.investment-controls input { width:210px;max-width:100% }
.investment-controls input::placeholder { color:var(--ic-muted) }
.investment-controls select:focus-visible,.investment-controls input:focus-visible,.investment-controls button:focus-visible { outline:2px solid var(--ic-blue);outline-offset:2px }
.investment-controls button { border:1px solid #2563eb;background:#2563eb;color:#fff;padding:8px 17px;font-weight:700;cursor:pointer;white-space:nowrap }
.investment-controls button:hover { background:#1d4ed8 }
.investment-controls .empty { padding:26px 18px;color:var(--ic-muted);text-align:center }
.investment-controls .audit-reason { min-width:190px;max-width:440px;overflow-wrap:anywhere }
.investment-controls .change { white-space:nowrap }
@media(max-width:720px) { .investment-controls { padding:16px 0 36px }.investment-controls .panel-header { padding:16px }.investment-controls .action-form { min-width:280px }.investment-controls .action-form input { flex:1;min-width:140px }.investment-controls td,.investment-controls th { padding:12px } }
</style>
                <div class="investment-controls {{ Auth('admin')->User()->dashboard_style == 'light' ? 'ic-light' : 'ic-dark' }}">

    <header class="ic-heading">
        <p class="eyebrow">Administration / Investment Management</p>
        <h1>Investment Controls</h1>
        <p class="intro">Review existing investments, manage their control states and inspect the history of administrative decisions.</p>
    </header>

    <div class="notice" role="note">
        <span class="mark" aria-hidden="true">&#9432;</span>
        <div><strong>How these controls work</strong><div>Actions prevent future automatic investment ROI and maturity settlement while non-active. They do not reverse prior payouts or change balances.</div></div>
    </div>

    @if(session('success'))
        <div class="flash success" role="status">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="flash error" role="alert">{{ implode(' ', $errors->all()) }}</div>
    @endif

    @foreach(['legacy' => $legacy, 'modern' => $modern] as $type => $items)
        <section class="panel" aria-label="{{ ucfirst($type) }} investments">
            <div class="panel-header">
                <div><h2>{{ ucfirst($type) }} Investments</h2><p>Latest 100 records</p></div>
                <span class="pill">{{ ucfirst($type) }} portfolio</span>
            </div>
            <div class="table-scroll">
                <table>
                    <thead><tr><th scope="col">ID</th><th scope="col">User</th><th scope="col">Original status</th><th scope="col">Control state</th><th scope="col">Action and reason</th></tr></thead>
                    <tbody>
                        @forelse($items as $item)
                            @php $key = $type . ':' . $item->id; $state = isset($controls[$key]) ? $controls[$key]->state : 'active'; @endphp
                            <tr>
                                <td class="mono">#{{ $item->id }}</td>
                                <td>{{ $item->user ?? 'N/A' }}</td>
                                <td class="subtle">{{ $item->active }}</td>
                                <td><span class="state {{ in_array($state, ['active','paused','suspended','flagged']) ? $state : '' }}">{{ $state }}</span></td>
                                <td>
                                    <form class="action-form" method="post" action="{{ route('admin.investment-controls.update', ['type' => $type, 'id' => $item->id]) }}">
                                        @csrf
                                        <select name="action" required aria-label="Action for investment {{ $item->id }}">
                                            <option value="">Choose action</option>
                                            @foreach(['pause','resume','suspend','reinstate','flag','clear_flag'] as $action)
                                                <option value="{{ $action }}">{{ str_replace('_',' ',ucfirst($action)) }}</option>
                                            @endforeach
                                        </select>
                                        <input name="reason" required minlength="5" maxlength="1000" placeholder="Reason (required)" aria-label="Reason for investment {{ $item->id }}">
                                        <button type="submit">Apply</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td class="empty" colspan="5">No investments to display.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    @endforeach

    <section class="panel" aria-label="Recent audit events">
        <div class="panel-header"><div><h2>Recent Audit Events</h2><p>Recorded investment-control decisions and reasons</p></div><span class="pill">Audit trail</span></div>
        <div class="table-scroll">
            <table>
                <thead><tr><th scope="col">Time</th><th scope="col">Investment</th><th scope="col">Admin</th><th scope="col">Change</th><th scope="col">Reason</th></tr></thead>
                <tbody>
                    @forelse($events as $event)
                        <tr>
                            <td class="subtle">{{ $event->created_at }}</td>
                            <td class="mono">{{ $event->investment_type }} #{{ $event->investment_id }}</td>
                            <td>{{ $event->admin_id }}</td>
                            <td class="change">{{ $event->from_state }} &rarr; {{ $event->to_state }}</td>
                            <td class="audit-reason">{{ $event->reason }}</td>
                        </tr>
                    @empty
                        <tr><td class="empty" colspan="5">No audit events recorded yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

                </div>
            </div>
        </div>
    </div>
@endsection
