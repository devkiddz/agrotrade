<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Investment Controls</title>
<style>body{font:15px system-ui,sans-serif;max-width:1150px;margin:30px auto;padding:0 16px;color:#17202a}table{border-collapse:collapse;width:100%;margin-bottom:28px}td,th{padding:9px;border-bottom:1px solid #ddd;text-align:left}input,select,button{padding:7px;max-width:180px}input{width:170px}button{cursor:pointer}small{color:#555}.err{color:#a00}</style></head><body>
<h1>Investment Controls</h1><p>Actions prevent future automatic investment ROI and maturity settlement while non-active. They do not reverse prior payouts or change balances.</p>
@if(session('success'))<p>{{ session('success') }}</p>@endif
@if($errors->any())<p class="err">{{ implode(' ', $errors->all()) }}</p>@endif
@foreach(['legacy' => $legacy, 'modern' => $modern] as $type => $items)
<h2>{{ ucfirst($type) }} investments (latest 100)</h2><table><thead><tr><th>ID</th><th>User</th><th>Original status</th><th>Control</th><th>Action and reason</th></tr></thead><tbody>
@foreach($items as $item)
@php $key = $type . ':' . $item->id; $state = isset($controls[$key]) ? $controls[$key]->state : 'active'; @endphp
<tr><td>{{ $item->id }}</td><td>{{ $type === 'legacy' ? ($item->user ?? 'N/A') : ($item->user ?? 'N/A') }}</td><td>{{ $type === 'legacy' ? $item->active : $item->active }}</td><td><strong>{{ $state }}</strong></td><td>
<form method="post" action="{{ route('admin.investment-controls.update', ['type' => $type, 'id' => $item->id]) }}">@csrf
<select name="action" required><option value="">Choose action</option>
@foreach(['pause','resume','suspend','reinstate','flag','clear_flag'] as $action)<option value="{{ $action }}">{{ str_replace('_',' ',ucfirst($action)) }}</option>@endforeach</select>
<input name="reason" required minlength="5" maxlength="1000" placeholder="Reason (required)"><button type="submit">Apply</button></form></td></tr>
@endforeach
</tbody></table>
@endforeach
<h2>Recent audit events</h2><table><thead><tr><th>Time</th><th>Investment</th><th>Admin</th><th>Change</th><th>Reason</th></tr></thead><tbody>
@foreach($events as $event)<tr><td>{{ $event->created_at }}</td><td>{{ $event->investment_type }} #{{ $event->investment_id }}</td><td>{{ $event->admin_id }}</td><td>{{ $event->from_state }} â†’ {{ $event->to_state }}</td><td>{{ $event->reason }}</td></tr>@endforeach
</tbody></table></body></html>



