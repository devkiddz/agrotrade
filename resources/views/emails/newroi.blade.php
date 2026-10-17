{{-- blade-formatter-disable --}}
@component('mail::message')
# Portfolio Update - Investment Returns Generated 📈

## Dear {{$user->name}},

**Congratulations!** Your investment portfolio has generated new returns. We're pleased to inform you that your strategic investment choices continue to perform well in the current market conditions.

### 💰 **Return Details**

@component('mail::panel', ['color' => 'success'])
**Investment Performance Summary**

**Investment Plan:** {{$plan}}<br>
**Return Amount:** {{$user->currency}}{{number_format($amount, 2)}}<br>
**Generated On:** {{$plandate}}<br>
**Status:** Credited to Your Account
@endcomponent

### 📊 **Performance Insights**

Your {{$plan}} investment plan continues to deliver consistent returns as part of our sophisticated investment strategy. This return reflects:

- **Market Analysis**: Our expert team's strategic market positioning
- **Risk Management**: Carefully balanced portfolio optimization
- **Technology Edge**: Advanced algorithmic trading systems
- **Diversification**: Multi-asset exposure for stability

### 🚀 **Maximize Your Growth Potential**

**Consider These Opportunities:**
- **Compound Growth**: Reinvest your returns for exponential growth
- **Portfolio Expansion**: Explore additional investment plans
- **Copy Trading**: Follow top-performing traders automatically
- **Premium Strategies**: Upgrade to higher-tier investment plans

@component('mail::button', ['url' => config('app.url').'/dashboard'])
View Portfolio Performance
@endcomponent

### 📈 **Your Investment Journey**

**Recent Activity:**
✅ Investment actively managed by our expert team<br>
✅ Returns generated and credited to your account<br>
✅ Portfolio rebalanced for optimal performance<br>
📊 Continuous monitoring and optimization in progress

**Next Steps:**
- Monitor your portfolio performance in real-time
- Consider reinvestment opportunities for compound growth
- Explore our advanced trading tools and analytics

### 💡 **Investment Insights**

@component('mail::panel')
**Market Commentary:** Current market conditions favor diversified investment strategies. Your {{$plan}} plan is positioned to capitalize on emerging opportunities while maintaining risk-adjusted returns.
@endcomponent

**Investment Tips:**
- **Consistency**: Regular investments often outperform market timing
- **Diversification**: Spread risk across multiple investment vehicles
- **Long-term Vision**: Focus on sustainable growth over quick gains
- **Professional Management**: Leverage our expert team's market expertise

### 📞 **Professional Investment Support**

Our investment advisory team is available to help you optimize your portfolio strategy:

@component('mail::button', ['url' => config('app.url').'/login', 'color' => 'success'])
Schedule Investment Consultation
@endcomponent

**Available Services:**
- Personal Portfolio Review
- Investment Strategy Optimization
- Market Analysis and Insights
- Risk Assessment and Management

### 🎯 **Ready to Grow Further?**

**Expansion Opportunities:**
- **Higher Tier Plans**: Unlock premium investment strategies
- **Copy Trading Elite**: Access to institutional-grade traders
- **Automated Rebalancing**: AI-powered portfolio optimization
- **VIP Services**: Dedicated investment advisor access

@component('mail::button', ['url' => config('app.url').'/login'])
Explore Investment Options
@endcomponent

---

### 📊 **Performance Transparency**

We believe in complete transparency regarding your investment performance. Access detailed analytics, historical returns, and comprehensive reporting through your dashboard.

**Key Metrics Available:**
- Real-time portfolio valuation
- Historical performance charts
- Risk-adjusted return analysis
- Benchmark comparisons

Thank you for trusting {{$settings->site_name}} with your investment goals. We remain committed to delivering exceptional results through our proven investment strategies.

**Best regards,**<br>
**The {{$settings->site_name}} Investment Team**<br>
*Your Partners in Financial Growth*

---

@component('mail::subcopy')
**Investment Disclaimer:** Past performance does not guarantee future results. All investments carry risk, and you may lose some or all of your invested capital. This notification is for informational purposes only and should not be considered as financial advice. Please review our [Risk Disclosure]({{config('app.url')}}/risk-disclosure) and consider consulting with a financial advisor.

Returns are calculated based on your investment plan's performance and market conditions. {{$settings->site_name}} employs professional investment strategies designed to optimize risk-adjusted returns.
@endcomponent

@endcomponent
{{-- blade-formatter-disable --}}
