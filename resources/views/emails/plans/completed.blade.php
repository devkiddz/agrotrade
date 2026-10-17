@component('mail::message')
# Investment Plan Completed

Dear {{ $name }},

Your investment in the **{{ $planName }}** plan has been completed successfully.

## Investment Details
- **Investment Amount:** {{ $currency }}{{ number_format($amount, 2) }}
- **Total Profit Earned:** {{ $currency }}{{ number_format($profit, 2) }}
- **Total Return:** {{ $currency }}{{ number_format($totalReturn, 2) }}
- **Start Date:** {{ $startDate }}
- **End Date:** {{ $endDate }}

@if($profit > 0)
Congratulations on your successful investment! The profits have been credited to your account balance.
@else
Your investment has been completed. Please check your account for the latest balance.
@endif

You can invest in another plan or withdraw your funds from your account dashboard.

@component('mail::button', ['url' => $siteUrl . '/login'])
Login to Account
@endcomponent

Thank you for choosing {{ $siteName }} for your investment needs.

Regards,<br>
{{ $siteName }} Team
@endcomponent
