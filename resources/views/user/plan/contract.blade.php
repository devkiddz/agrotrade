@extends('layouts.app')
@section('title', 'Investment Contract')

@section('styles')
@parent
<style>
    .contract-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem;
        @apply bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700;
    }

    .contract-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .contract-section {
        margin-bottom: 1.5rem;
    }

    .contract-section h3 {
        @apply text-lg font-medium text-gray-900 dark:text-white mb-2;
    }

    .contract-section p {
        @apply text-gray-600 dark:text-gray-300 mb-3;
    }

    .contract-table {
        width: 100%;
        border-collapse: collapse;
        margin: 1rem 0;
    }

    .contract-table th {
        @apply bg-gray-100 dark:bg-gray-700 text-left px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300;
    }

    .contract-table td {
        @apply border-t border-gray-200 dark:border-gray-700 px-4 py-2 text-sm text-gray-700 dark:text-gray-300;
    }

    .contract-footer {
        margin-top: 3rem;
        @apply text-center text-gray-500 dark:text-gray-400 text-sm;
    }

    .signature-section {
        margin-top: 4rem;
        @apply border-t border-gray-200 dark:border-gray-700 pt-4;
    }

    .signature-row {
        @apply flex flex-col md:flex-row justify-between mt-8;
    }

    .signature-box {
        @apply border-b border-gray-400 dark:border-gray-500 w-full md:w-5/12 mb-4 md:mb-0 pb-1;
    }

    .company-stamp {
        width: 150px;
        height: 150px;
        position: relative;
    }

    .company-stamp img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        opacity: 0.8;
    }

    /* Print styles */
    @media print {
        body {
            background-color: white;
            color: black;
            font-size: 12pt;
        }

        .contract-container {
            border: none;
            box-shadow: none;
            padding: 0;
            max-width: 100%;
        }

        .print-button {
            display: none;
        }

        @page {
            margin: 2cm;
        }
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Action Bar -->
    <div class="max-w-4xl mx-auto mb-8 flex justify-between items-center">
        <div>
            <a href="{{ route('user.plans.details', $userPlan->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white rounded-lg transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Plan Details
            </a>
        </div>

        <div>
            <button onclick="window.print()" class="print-button inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                </svg>
                Print Contract
            </button>
        </div>
    </div>

    <!-- Contract Document -->
    <div class="contract-container">
        <div class="contract-header">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('dash/images/logo.png') }}" alt="BlueTrade Logo" class="h-16">
            </div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">INVESTMENT AGREEMENT</h1>
            <p class="text-gray-500 dark:text-gray-400">Contract #{{ strtoupper(substr(md5($userPlan->id), 0, 8)) }}</p>
        </div>

        <div class="contract-section">
            <p>This Investment Agreement (the "Agreement") is entered into on {{ $userPlan->created_at->format('F d, Y') }} ("Effective Date") by and between:</p>
            <p><strong>BlueTrade Ltd</strong>, a company registered under the laws of England and Wales with registered address at 123 Financial Street, London, EC1A 1BB, United Kingdom ("Company")</p>
            <p>and</p>
            <p><strong>{{ auth()->user()->name }}</strong>, with registered address at {{ auth()->user()->address ?: 'Address on file' }} ("Investor").</p>
        </div>

        <div class="contract-section">
            <h3>1. INVESTMENT DETAILS</h3>
            <p>The Investor agrees to invest in the Company's {{ $userPlan->plan->name }} investment plan with the following terms:</p>

            <table class="contract-table">
                <tr>
                    <td><strong>Investment Plan:</strong></td>
                    <td>{{ $userPlan->plan->name }}</td>
                </tr>
                <tr>
                    <td><strong>Investment Amount:</strong></td>
                    <td>{{ Auth::user()->currency }}{{ number_format($userPlan->invested_amount, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Return Rate:</strong></td>
                    <td>{{ $userPlan->plan->expected_return }}% per {{ $userPlan->plan->return_interval }}</td>
                </tr>
                <tr>
                    <td><strong>Total Expected Return:</strong></td>
                    <td>{{ $userPlan->plan->total_return }}% ({{ Auth::user()->currency }}{{ number_format($userPlan->expected_profit, 2) }})</td>
                </tr>
                <tr>
                    <td><strong>Investment Term:</strong></td>
                    <td>{{ $userPlan->plan->duration }} {{ Str::plural('Day', $userPlan->plan->duration) }}</td>
                </tr>
                <tr>
                    <td><strong>Start Date:</strong></td>
                    <td>{{ $userPlan->activated_at ? $userPlan->activated_at->format('F d, Y') : 'Upon payment confirmation' }}</td>
                </tr>
                <tr>
                    <td><strong>Maturity Date:</strong></td>
                    <td>{{ $userPlan->expires_at ? $userPlan->expires_at->format('F d, Y') : 'To be determined upon activation' }}</td>
                </tr>
                <tr>
                    <td><strong>Payout Schedule:</strong></td>
                    <td>{{ ucfirst($userPlan->plan->return_interval) }}</td>
                </tr>
                @if($userPlan->compound_interest)
                <tr>
                    <td><strong>Compound Interest:</strong></td>
                    <td>Enabled</td>
                </tr>
                @endif
                @if($userPlan->auto_renewal)
                <tr>
                    <td><strong>Auto-Renewal:</strong></td>
                    <td>Enabled</td>
                </tr>
                @endif
            </table>
        </div>

        <div class="contract-section">
            <h3>2. INVESTMENT PURPOSE</h3>
            <p>The funds invested by the Investor will be allocated to {{ strtolower($userPlan->plan->category->name) }} investments as per the Company's investment strategy. The Company will manage these investments on behalf of the Investor to generate the returns specified in this Agreement.</p>
        </div>

        <div class="contract-section">
            <h3>3. PAYMENT OF RETURNS</h3>
            <p>The Company shall pay returns to the Investor according to the specified payout schedule. Returns will be calculated based on the original investment amount and credited to the Investor's account within the platform.</p>
            <p>At the end of the investment term, the original investment amount plus any remaining returns will be made available for withdrawal or reinvestment at the Investor's discretion, unless auto-renewal has been selected.</p>
        </div>

        <div class="contract-section">
            <h3>4. RISK DISCLOSURE</h3>
            <p>The Investor acknowledges that all investments carry risks and that past performance is not indicative of future results. The Company makes reasonable efforts to achieve the projected returns but cannot guarantee them due to market fluctuations and other factors beyond its control.</p>
            <p>The risk level for this investment plan is classified as: {{ $userPlan->plan->risk_level <= 2 ? 'Low' : ($userPlan->plan->risk_level <= 3 ? 'Medium' : 'High') }}</p>
        </div>

        <div class="contract-section">
            <h3>5. EARLY TERMINATION</h3>
            <p>Should the Investor request early termination of this Agreement before the maturity date, an early withdrawal fee of {{ $userPlan->plan->early_withdrawal_fee }}% of the invested amount may be applied, and returns may be prorated or forfeited as per the Company's policies.</p>
        </div>

        <div class="contract-section">
            <h3>6. TERMS AND CONDITIONS</h3>
            <p>This Agreement is subject to the Company's general Terms and Conditions, Privacy Policy, and AML/KYC procedures, which are incorporated herein by reference. The Investor confirms having read and agreed to these policies as published on the Company's website.</p>
        </div>

        <div class="signature-section">
            <p>IN WITNESS WHEREOF, the parties hereto have executed this Agreement as of the Effective Date.</p>

            <div class="signature-row">
                <div>
                    <div class="signature-box">
                        @if($userPlan->status === 'active')
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAAA2CAMAAAC3a6dCAAAAqFBMVEVHcEz///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8X+nl7AAAAOHR0cHMAAABGaXJtIFNpZ25hdHVyZVxuQmx1ZVRyYWRlIE1hbmFnZW1lbnQDc3oIZmllbGQtaWTFu7DaAAAAEXRSTlMAgEAwQL/vYBDfn69wj1CPcKUGkV4AAAYgSURBVHja7Zrpkps4FIYRiwADMgZ7Ft/2pJ3updNLMt3p93+xHAEGYzC2y5mqpKb+dZUxxuiTdM5Bomna2UtLS0tLS0tLS0tLS0tL6yTRszWvSqlfakymAcF0daUzXQEzLOmY9VGdcU5vpWpUJMY4+7F80APPUEA8RuX5LLzdpneCq8S4MmGtMmPZLvUdXk+LH5ldd7fWdfszuBTrC2xts36Ul9+iLdPRms1n2KhM4zzYUuM9pKrid8xrWfFGeWs38zvlDYfKiO7HVamJQtsxDM9+Rjg9Ngyn3x3G9vMjzmj1+FYPLdNx3Poo1aP1zOv2Q13uvVmaelyN+o4k+jOvZlBXnPmETsq2vvMG1oxfLnwcZXHCo/JTEZW8nHi/nKdRnvLcz4LHhy8cLkXR43weFzz3o6d0JMswdd2wuL7j2oP3aKZlALel21F4Y5VZlmn2u+0GzzIM37bNbvug+1mndLFtBLovKK/nDjtr3vU98FR7VIRRnfnBpWwrBJLJ0/Ffl+m2o9uB1e+2S5YY6NnuIZ5tGFHfrG9xvhWAD95wYUutZ7HGfRlEiYYvfbBG+VwSeGV+4TUOmLhJ8DsuDxHhcp6J5yQ84YpokiZRHuRJVCaB7/Ne1k/3LBWs2aFw7Z7YYU3BO2hJNob8Ly7dkL2Nfzc8YXkfr2mLDvJOK8oKX75GZZjkZVx+7Q4sye/87kaXtqTACoUFrzV39MiLPGziiDH5XtufHy6DpYxg6LppSj3a7Fz0j8BiB1h7dXOTuV+CJZfJg7YSyfzolmdNnDUPd+CQFw6Gjq7LNyvLj7Deu+TbwavZ6kPyblRJL20zvmRdkk0Rt3k63GCLrChQvA0/QpHIazv6/gkWjGkh3QysjEmeOE+DJrY+AouMEyIEcP8grCZdoKhZ122nT7VGl8fRu7C0+hhSm+33p9ImT7rPdB5Fkcc8OcXw9U9Y3z8FS5aRnf0/frTZueTtw1LNoTsJVkOu+WStJ+SZh0X1JziRnwVMFgcH/2lYb++yL26z7m7ic7DUntJWw+rcxBCWJS+EHCw8AksetQlSYcnVIPC+zaYeYdl7WGbz6tib5mMY81+GtRu9Nk2yd/1zPLDtH2D9eoI1bsn5rtYTcvO/wqsrnL+FBfOpJix9vR5/gNd6kBU97Xlmwmo8rtVwsdmydZ5efXkNll0fdLv+Mu2WOv4eBSs/XB2sxOq1WazvtAsm/VN7WwfSzbaONFv54wt42Wyx1q4TYUklIWJmW2XlmzfViN2Vf7Qi5nSXVYKDpX7kJgfttujcF/oRy9GdgzOMy+s+LPNk/2EYfc0VzqBb5OPmvMzoaz1I1dFrdn2KznKF82cRtrQix6ClSKsVPd/EGY97p+egAQSLGCGmohZhp/xwO2hJ9g/M9d6BZ2c9XVKzhg/6AYekc7vCfobF5dXhQtYb9ursYQnX+qaKdHun4OAlWP3Orv+AgjWX6nIrlT3JOijLd3cJTFIohF7sXmxfFXkPa+YzLRPctquvZZfFSZZkd2FtaxjGcW1su5fHz8laxmj1vCnwp2SNpQV6E1yJC46cc/EeVnroqQc1gu3vYQUSeRIEcNPpvEVWQq69jMdy6CMIirKGBawvspw07Fd5qa4JULzFL6tfB8uiCYyqMNTSkXstZtNcwjJc08NMz/KGz8FqNzmwIw28SYzTpLjJI9n0vZOVO6/xPqvirvvmu4YVzZd5wFMuRpnHRZyM+uxh/ZQJT5tYTnNVFmdpnJbxaJyHY57HDzc8HCWB0IX78zSPJPGlOP4bnjwR9cGqwkJQUw+QZahbOqM4Y54MYwCrcA3Tkotq9vMyCLMwKeafn+6qrm74rrswdZ1xJSAGu4YPXd0YiKs77BYljK0bRg+uORB3RV3LGN4MxyWM3QPbuYZywTZm7SSEfwzT0F0dXEPe5wnw7oPRP0IngjWpkfWxSA+j9yP8dRfIklLFcgn5HqaqwwrgO1cg64RnXYGsS551BbLOdtYVyDpJWVcg65JnXYGsc551/TfI0qLQ0tLS0tLS0tLS0tLS+mv6E3r2AeMv+vxZAAAAAElFTkSuQmCC" alt="Signature" style="max-width: 150px;">
                        @endif
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Investor: {{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-500">Date: {{ $userPlan->created_at->format('F d, Y') }}</p>
                </div>

                <div>
                    <div class="signature-box">
                        @if($userPlan->status === 'active')
                        <img src="data:image/png;base64,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" alt="Signature" style="max-width: 150px;">
                        @endif
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">For BlueTrade Ltd</p>
                    <p class="text-xs text-gray-500 dark:text-gray-500">Date: {{ $userPlan->activated_at ? $userPlan->activated_at->format('F d, Y') : 'Pending activation' }}</p>
                </div>
            </div>

            <div class="flex justify-end mt-10">
                @if($userPlan->status === 'active')
                <div class="company-stamp">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAACWCAMAAAAL34HQAAABR1BMVEVHcEz////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////uKVtJAAAAbXRSTlMAAgMFCAwSGSAoLjQ7Qz9IUFpga2lycHN4fIOIjpWZlZ+lq66ms7a5vcDBw8XHycrMzc/R09TV1tfY2drb3N3e3+Dh4uPk5ebn6Onq6+zt7u/w8fLz9PX29/j5+vv8/f5gmr6VAAAIPElEQVR42t2beVfaShzHB8JAWm2ve30+FRASQGQL+w6yyI6AoriVXu3z/d/Ce9sCYczM/Ca/SbCcfv/pceTkk+8smbB02vFT4nn82O2+9/v97vHxsfcfu/en3a5377n3PIcaZo+SJofH/XsBxefMgY/9435IbedZ0qJ73JcMeS/f+5IPHrvdRHqYWsyPm5IC/f5xN36YiehQcbr9vpLDe9m+74dSKO/+uxurhzQW1afboSLBex+shwCLbcK+Msj7gYitijXp9tUZ3ns/NpnLuXeU4X373VRc7IcIHXLfj8ni8j0Nhve9JkMXXO9HJBvee1WaLngsrshhrB7avesjGSqVDim6xPMQ7z0Kjd51EKt76JFweF9joTqUJo2Id384G6h7qBUGPxNIf9wHxdIj/PrgP0KuPzEC94mua9xHmfAPMVjH0m3wPpCe3p+NoHsPnkE9fB9Ikg5fHYjce+gQ+I8Y0AO0Gd8DWdHpD8TgvXcg6Zx2+F7ThL8QXO/hgyz26I+kzxvQ7b0n2bQ/EYP3NXHuPcnp/UJowtdk0nsHoLr3RYz46x8eQOLcewDSvSZieoJz71HY7jUx0Ru8e4+2e03MhPnfJww+S1z3noTnXhOTvcS493CO940R3FOsew/W7jUx3Wu0e4/W7jUxXw/t3qO1e038Z7Arz703jnDvjSXce6g3bveeiHXvjSrcu9fEvXcy4t57zcK9J8dw780q3HszCfeeK+ree9XFvTeZce9NZ9x7sxn3Hi/i3uPS7r0XnXtPV7v3tAnv3tMGzLv3EnLvvWrce9MSvu/Nt9zXuPeWS9y7d7Xee/Gydu8FavfebN69F6jde4MV956ndu/Zfu/ee1W695YL7r2Jontv0u/em0i496Zd7r1pr3tvuuDemyq696ZEF5ZwHxfdexMu914TS7j3XnTuvUGXey9Wu/cEjXuvW3DvdRTuvUjt3pMz7r1Fv3tvUOPeE9TuvZWCe29F4d5bSLv3FtLuvRTde90u914X7957qbj35hTuvbTCvTdHiS4c4T5vcO8FBvdet+DeG1a49ya87r1FhXtvVOHec8nuPV7j3hPS7r1pmXvPrXLvjWXce5aEe68rue89Q3DvOWX33liwew/gvUeAt14T9L1nqNx7gMq9l0q592ZS7r1hgntvRcK9NxNx7y2k3HvTGfdeZ8S911G79/rde50R995syr03InPvTXvde9Mu915nxL3XkXXvraf8772OhHvPdO9tBNx7qxn33lLGvbeRce+ty7r3lhTuvaZfuPc2A+69pZR7L0i597Zk3XsrEvceo3bvrQRl954TcO9Z/e69TYV7b8zt3tvMuPe2ZNx7WyH33qbCvbcic++NB9179kjIvbdtcO9tuNx7Gy733rrLvbeuce81/cK9N+Ny722r3XucnHtvK+Xe2w669+ywe29D4d7biLj3VmXde1sp9956zL23mXLvLcnuvdEe996Iwr03JuvemxRdeA73ngvr3rMi7r11l3tvQ+3e2wq49zbde9sy996Uxr23SImucO9tGtx7Gy733no/3HuDKveeNeBw7wVc994KK+HecyPuvW2Ne29N5d6b9rr3Zl3uvW2Xe2/L5d7bVrn3Ngd87r0twb03kvfvQFDf4aa23Hs7EffeZsy9t51y780H3HtuMD5/qZdFddiAe2+74N7bk3XvzRTce4k/MjtxV3eY7sFZCOdP42C/4X+PmN97u7LuvaVQm+I+8H8GF6GCioP9KnrtTVObqPcmU+69jWj7pwVYuzT/bMLfi43PX0Fn33sTSfdebDvLSE2/+d+XsaLsaG9Nr71Rj3tvq9AmaYh/h/9VaGO1qzvcryIB9x6bcu/tZNrOXPvXlzJWu7rDfRY2OxFw700l3HujbvefBJODgxOoXPvnj7DZG/C598Zc7r3VaJvj8vJwFyq3+evXgNvszQbde6tx995orP1zhcvfVLHC5bY/fx1wm73tgHtvyhVpg84+l5d/wuWqFW73v65iszfuce/NJ9x7o5H2TwicXGH51wptts3OH6DZGw+6965ds6gOl4e7f8LlClv/usLN3mbevbdd6Il7z59z781F2w5U5ODgClRu61+72OyNhd17Qx733kCs7chxBbo6hMvVttt/XQOzN1Fw7/ll994krscpVIcn/7p0mx23/c/X8N9Pi+69gbx7bzrSdiTo4PIEKrfd+be42ZvLu/eC7r2hWNvBe1Wb3j1cbqtlqBwwew733qzLvTcZaztYm+IOdEG17R9QOczsLUXce4Mu917Q/SeT9OAKRbmNf3+KzN5c3r3nce+NxNoOXtuqmh1QbhMqh5u92bx7L+nem4y1Hdy2VTWDy7XabsxmbyXg3pvxu/d4v/vPJenBLXrbtv4Dl1uHyqFmb0nWvTft9//5rau0basdqFzrP3C5dtvsyGZvwuveG3X5/9iSzu1Fhdsf/8XNXj/q3nNj/j+3pDNu26prCJdr/YvctmTNXlDl3pvzuPcmo/4/e5LO3bZb7UILs1n/P2r2ZvPuvYDH/ReQdKptu+1OoXKb7TZWEzd7i7LuPQ/h/wtIeue2Pc+57dbZETB7Szn33oTK/xeTdNINs+tXu0a5zXZ7B5i96aB7b9jl/wtKOumGabcHldu0zmCzF3DvzQfdf0l3d8O0reNWu92Gy63DszeTc+8NOT1BTf/f5fbAcnfA7K0E3XuDTl9gUpVOuGEYbXjbGoZpHSN/rym69wYoZ2BS/ZHjGMbUX7m7O3D2Aj56n5/9VDGO5f+nszft9QUm5ct/DJXbwH++Nj6/QB2vL/AXdcv/95u9pT7/Xnx+CT1eXyAXl9/ktu12cQsddvqCufh8oF+3dw2bvW6fL5SLzw/6dXtn0OxNuH3B//8Bvjpsi1cWF+8AAAAASUVORK5CYII=" alt="Company Stamp">
                </div>
                @endif
            </div>
        </div>

        <div class="contract-footer">
            <p>This document is electronically generated and is valid without a handwritten signature.</p>
            <p>Document ID: {{ strtoupper(substr(md5($userPlan->id . auth()->user()->id), 0, 16)) }}</p>
            <p>Generated on: {{ now()->format('F d, Y - h:i A') }}</p>
        </div>
    </div>
</div>
@endsection
