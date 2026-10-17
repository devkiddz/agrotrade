{{-- blade-formatter-disable --}}
@component('mail::message')
# Welcome to {{$settings->site_name}}, {{$user->name}}!

## Your Gateway to Advanced Investment Opportunities

Dear {{$user->name}},

We are thrilled to welcome you to the **{{$settings->site_name}}** family - where intelligent investing meets cutting-edge technology. Your journey toward financial growth and portfolio diversification begins today.

### 🚀 **What Makes Us Different**

**{{$settings->site_name}}** is more than just a trading platform. We're your strategic partner in building long-term wealth through:

- **Advanced Algorithmic Trading** - Leverage AI-powered strategies
- **Copy Trading Excellence** - Follow and replicate successful traders
- **Diversified Investment Plans** - From conservative to aggressive growth options
- **Real-Time Analytics** - Professional-grade market insights
- **Risk Management Tools** - Protect and optimize your investments

### 📈 **Your Next Steps to Success**

@component('mail::panel')
**Getting Started is Simple:**

1. **Complete Your Profile** - Verify your account for enhanced security
2. **Explore Investment Options** - Review our curated investment plans
3. **Make Your First Deposit** - Start with an amount you're comfortable with
4. **Choose Your Strategy** - Select from algorithmic trading or copy trading
5. **Monitor & Grow** - Track your portfolio performance in real-time
@endcomponent

@component('mail::button', ['url' => config('app.url').'/dashboard'])
Access Your Dashboard
@endcomponent

### 💡 **Investment Opportunities Await**

**Beginner-Friendly Options:**
- Low-risk investment plans with steady returns
- Educational resources and market analysis
- Dedicated support for new investors

**Advanced Trading Features:**
- Copy successful traders automatically
- Access to premium market signals
- Advanced portfolio management tools

### 🛡️ **Your Security is Our Priority**

Rest assured that your investments are protected by:
- Bank-level encryption and security protocols
- Regulatory compliance and transparent operations
- 24/7 monitoring and fraud protection
- Segregated client funds for maximum safety

### 📞 **Expert Support When You Need It**

Our professional team is here to guide you every step of the way:

@component('mail::button', ['url' => config('app.url').'/support', 'color' => 'success'])
Contact Our Investment Advisors
@endcomponent

**Available Support:**
- 24/7 Customer Service
- Personal Investment Consultations
- Educational Webinars and Resources
- Market Analysis and Insights

---

### 🎯 **Ready to Begin?**

The global markets never sleep, and neither do the opportunities. Whether you're looking to:
- Build retirement wealth
- Generate passive income
- Diversify your investment portfolio
- Learn advanced trading strategies

**{{$settings->site_name}}** provides the tools, expertise, and support you need to achieve your financial goals.

@component('mail::panel', ['color' => 'success'])
**Special Welcome Offer:** As a new member, you'll receive complimentary access to our premium market analysis for your first 30 days. Start making informed investment decisions from day one!
@endcomponent

Welcome aboard, and here's to your investment success!

**The {{$settings->site_name}} Team**<br>
*Empowering Intelligent Investors Since Day One*

---

@component('mail::subcopy')
**Disclaimer:** All investments carry risk, and past performance does not guarantee future results. Please ensure you understand the risks involved and consider seeking independent financial advice if needed. {{$settings->site_name}} is committed to responsible investing practices.

Visit our [Risk Disclosure]() page for more information.
@endcomponent

@endcomponent
{{-- blade-formatter-disable --}}
