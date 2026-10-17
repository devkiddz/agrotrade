{{-- blade-formatter-disable --}}
@component('mail::message')
# Withdrawal Request - {{$foramin  ? 'Administrative Review Required' : 'Fund Transfer Update'}}

@if ($foramin)
## Administrative Alert: Withdrawal Request Pending

Dear Administrator,

A withdrawal request has been submitted and requires your immediate attention for review and processing.

**Withdrawal Request Details:**
- **Client:** {{$user->name}}
- **Amount:** {{$user->currency}}{{number_format($withdrawal->amount, 2)}}
- **Request Date:** {{now()->format('F j, Y \a\t g:i A')}}
- **Status:** Pending Administrative Review
- **Reference ID:** #{{$withdrawal->id ?? 'WDR'.time()}}

**Required Action:** Please review the client's account status, verify compliance requirements, and process the withdrawal request through the admin dashboard.

@component('mail::button', ['url' => config('app.url').'/admin/withdrawals'])
Review Withdrawal Request
@endcomponent

@component('mail::panel')
**Compliance Check:** Ensure all KYC/AML requirements are met and account verification is complete before processing.
@endcomponent

@else
## Dear {{$user->name}},

@if ($withdrawal->status == 'Processed')
**Your withdrawal has been successfully processed! 🎉**

We are pleased to confirm that your withdrawal request has been approved and processed. The funds are now on their way to your designated account.

**Transaction Summary:**
- **Amount:** {{$user->currency}}{{number_format($withdrawal->amount, 2)}}
- **Processing Date:** {{now()->format('F j, Y \a\t g:i A')}}
- **Status:** Successfully Processed
- **Reference ID:** #{{$withdrawal->id ?? 'WDR'.time()}}

@component('mail::panel', ['color' => 'success'])
**Funds Transfer Complete:** Your withdrawal has been sent to your registered account. Depending on your bank or payment method, funds should appear within 1-5 business days.
@endcomponent

**What to Expect:**
- **Bank Transfers:** 2-5 business days
- **Digital Wallets:** Within 24 hours
- **Cryptocurrency:** 1-3 network confirmations

@component('mail::button', ['url' => config('app.url').'/dashboard/transactions'])
View Transaction History
@endcomponent

**Continue Growing Your Portfolio:**
- Reinvest your profits for compound growth
- Explore our Copy Trading opportunities
- Access premium investment strategies

@else
**Your withdrawal request is being processed - Thank you for your patience**

We have successfully received your withdrawal request and our financial operations team is currently reviewing and processing your transaction.

**Processing Status:**
- **Amount:** {{$user->currency}}{{number_format($withdrawal->amount, 2)}}
- **Status:** Under Review & Processing
- **Reference ID:** #{{$withdrawal->id ?? 'WDR'.time()}}
- **Submitted:** {{now()->format('F j, Y \a\t g:i A')}}

@component('mail::panel')
**Processing Timeline:** Withdrawal requests are typically processed within 1-3 business days. Our team conducts thorough security checks to ensure your funds are transferred safely and securely.
@endcomponent

**Security Verification Process:**
✅ Account verification and compliance check<br>
✅ Anti-fraud and security screening<br>
🔄 **Currently processing your withdrawal**<br>
⏳ Final approval and fund transfer

You will receive an immediate notification once your withdrawal is approved and the funds are transferred to your account.

@component('mail::button', ['url' => config('app.url').'/dashboard/withdrawals'])
Track Withdrawal Status
@endcomponent

@endif
@endif

---

**Important Security Information:**

@component('mail::panel', ['color' => 'warning'])
**Security Reminder:** For your protection, we will never ask for your login credentials via email. If you did not request this withdrawal, please contact our security team immediately.
@endcomponent

**Need Assistance?**
Our dedicated financial operations team is available to assist you with any questions regarding your withdrawal.

@component('mail::button', ['url' => config('app.url').'/support', 'color' => 'success'])
Contact Support Team
@endcomponent

**Quick Support Options:**
- 24/7 Live Chat Support
- Direct Email: {{$settings->contact_email}}
- Phone: Available during business hours

Best regards,<br>
**The {{config('app.name')}} Financial Operations Team**<br>
*Secure. Reliable. Trusted.*

@component('mail::subcopy')
This withdrawal notification is sent for security purposes. {{config('app.name')}} employs industry-standard security protocols to protect your funds. All withdrawal requests are subject to our standard verification procedures. For more information, visit our [Security Center]({{config('app.url')}}/terms).
@endcomponent

@endcomponent
{{-- blade-formatter-disable --}}
