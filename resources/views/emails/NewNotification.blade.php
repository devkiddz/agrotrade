{{-- blade-formatter-disable --}}
@component('mail::message')
# {{ $salutaion ? $salutaion : "Important Update" }} {{ $recipient}},

@if ($attachment != null)
    @component('mail::panel')
    **Document Attached:** Please review the attached document for additional details regarding this notification.
    @endcomponent
    <div style="text-align: center; margin: 24px 0;">
        <img src="{{ $message->embed(asset('storage/'. $attachment)) }}" style="max-width: 100%; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);" alt="Attachment">
    </div>
@endif

## Account Notification

{!! $body !!}

---

### 📞 **Need Assistance?**

If you have any questions regarding this notification or need clarification on any investment-related matters, our professional support team is here to help.

@component('mail::button', ['url' => config('app.url').'/support', 'color' => 'success'])
Contact Support Team
@endcomponent

**Quick Support Options:**
- **24/7 Live Chat:** Instant assistance through your dashboard
- **Email Support:** {{$settings->contact_email}}
- **Phone Support:** Available during business hours
- **Investment Advisory:** Schedule a consultation with our experts

### 🔔 **Notification Preferences**

You can manage your notification preferences and choose which updates you'd like to receive through your account settings.

@component('mail::button', ['url' => config('app.url').'/dashboard/settings'])
Manage Notifications
@endcomponent

### 📊 **Stay Informed**

**Keep track of your investment journey:**
- Portfolio performance updates
- Market insights and analysis
- Trading opportunities and alerts
- Account security notifications
- Platform updates and new features

---

### 🛡️ **Security Notice**

@component('mail::panel', ['color' => 'warning'])
**Important:** {{config('app.name')}} will never ask for your login credentials, passwords, or sensitive account information via email. If you receive any suspicious communications, please contact our security team immediately.
@endcomponent

**Best regards,**<br>
**The {{config('app.name')}} Team**<br>
*Your Trusted Investment Partner*

---

@component('mail::subcopy')
This notification was sent to you as part of your {{config('app.name')}} account communications. If you believe you received this email in error or have concerns about your account security, please contact our support team immediately.

You can update your communication preferences or unsubscribe from certain notifications through your [Account Settings]({{config('app.url')}}/dashboard/settings). For important security and account-related notifications, we recommend keeping notifications enabled.

© {{date('Y')}} {{$settings->site_name}}. All rights reserved. | [Privacy Policy]({{$settings->site_address}}/privacy) | [Terms of Service]({{$settings->site_address}}/terms) 
@endcomponent

@endcomponent
{{-- blade-formatter-disable --}}
