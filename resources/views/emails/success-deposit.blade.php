{{-- blade-formatter-disable --}}
@component('mail::message')
# Deposit Confirmation - {{$foramin  ? 'Admin Notification' : 'Welcome to Your Trading Journey'}}

@if ($foramin)
## Administrative Alert: New Deposit Received

Dear Administrator,

We are pleased to inform you that a new deposit has been successfully received:

**Deposit Details:**
- **Client:** {{$user->name}}
- **Amount:** {{$user->currency}}{{number_format($deposit->amount, 2)}}
- **Status:** {{$deposit->status}}
- **Date:** {{now()->format('F j, Y \a\t g:i A')}}

@if($deposit->status != "Processed")
**Action Required:** Please review and process this deposit through the admin dashboard.

@component('mail::button', ['url' => config('app.url').'/admin/dashboard'])
Process Deposit
@endcomponent
@else
This deposit has been automatically processed and the client's account has been credited.
@endif

@else
## Dear {{$user->name}},

@if ($deposit->status == 'Processed')
**Congratulations! Your deposit has been successfully processed.**

We are delighted to confirm that your deposit of **{{$user->currency}}{{number_format($deposit->amount, 2)}}** has been received and processed. Your trading account has been credited with the full amount.

**What's Next?**
- Your funds are now available for trading
- Explore our advanced trading tools and analytics
- Start building your investment portfolio today

@component('mail::button', ['url' => config('app.url').'/dashboard'])
Start Trading Now
@endcomponent

**Investment Opportunities Await:**
- Copy successful traders with our Copy Trading feature
- Access real-time market data and advanced charts
- Benefit from our algorithmic trading tools

@else
**Your deposit is being processed - Thank you for choosing us!**

We have successfully received your deposit of **{{$user->currency}}{{number_format($deposit->amount, 2)}}**. Our financial team is currently reviewing and confirming your transaction.

**Processing Status:** Under Review
**Expected Processing Time:** 1-3 business hours


You will receive an immediate notification once your deposit is confirmed and your trading account is credited.

@component('mail::panel')
**Security Notice:** We employ bank-level security protocols to ensure your funds are safe and secure throughout the processing period.
@endcomponent

@endif
@endif

---

**Need Assistance?**
Our dedicated support team is available 24/7 to assist you with any questions.

@component('mail::button', ['url' => config('app.url').'/support', 'color' => 'success'])
Contact Support
@endcomponent

Best regards,<br>
**The {{config('app.name')}} Team**<br>
*Your Trusted Trading Partner*

@component('mail::subcopy')
This is an automated message from {{config('app.name')}}. For security purposes, please do not share this email with anyone. If you did not initiate this deposit, please contact our support team immediately.
@endcomponent

@endcomponent
{{-- blade-formatter-disable --}}
