<!-- Flash Message -->
@if (Session::has('message'))
<div x-data="{ show: true }"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform translate-y-2"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform translate-y-2"
     class="relative bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 rounded-xl p-5 mb-6 shadow-lg backdrop-blur-sm">
    <div class="flex items-start justify-between">
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-red-500/10 rounded-full flex items-center justify-center">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-600"></i>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <h4 class="text-sm font-semibold text-red-800 mb-1">Alert</h4>
                <p class="text-sm text-red-700 leading-relaxed">{{ Session::get('message') }}</p>
            </div>
        </div>
        <button @click="show = false"
                class="flex-shrink-0 ml-4 p-2 text-red-400 hover:text-red-600 hover:bg-red-500/10 rounded-lg transition-all duration-200">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>
</div>
@endif

<!-- Validation Errors -->
@if ($errors->any())
<div x-data="{ show: true }"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform translate-y-2"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform translate-y-2"
     class="relative bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 rounded-xl p-5 mb-6 shadow-lg backdrop-blur-sm">
    <div class="flex items-start justify-between">
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-red-500/10 rounded-full flex items-center justify-center">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-red-600"></i>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <h4 class="text-sm font-semibold text-red-800 mb-2">Validation Errors</h4>
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="flex items-start space-x-2">
                            <i data-lucide="dot" class="w-3 h-3 text-red-500 mt-1 flex-shrink-0"></i>
                            <span class="text-sm text-red-700">{{ $error }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button @click="show = false"
                class="flex-shrink-0 ml-4 p-2 text-red-400 hover:text-red-600 hover:bg-red-500/10 rounded-lg transition-all duration-200">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>
</div>
@endif

<!-- Notify Alert -->
@if (Auth::check() && Auth::user()->notify_status == 'on' && Auth::user()->notify)
<div x-data="{ show: true }"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform translate-y-2"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform translate-y-2"
     class="relative bg-gradient-to-r from-amber-50 to-yellow-50 border-l-4 border-amber-500 rounded-xl p-5 mb-6 shadow-lg backdrop-blur-sm">
    <div class="flex items-start justify-between">
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-amber-500/10 rounded-full flex items-center justify-center">
                    <i data-lucide="bell" class="w-5 h-5 text-amber-600"></i>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <h4 class="text-sm font-semibold text-amber-800 mb-1">Notification</h4>
                <p class="text-sm text-amber-700 leading-relaxed">{{ Auth::user()->notify }}</p>
            </div>
        </div>
        <button @click="show = false"
                class="flex-shrink-0 ml-4 p-2 text-amber-400 hover:text-amber-600 hover:bg-amber-500/10 rounded-lg transition-all duration-200">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>
</div>
@endif

<!-- Signal Alert -->
@if(Auth::check() && Auth::user()->signal_status == 'on' && Auth::user()->user_signal)
<div x-data="{ show: true }"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform translate-y-2"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform translate-y-2"
     class="relative bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 rounded-xl p-5 mb-6 shadow-lg backdrop-blur-sm">
    <div class="flex items-start justify-between">
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-red-500/10 rounded-full flex items-center justify-center">
                    <i data-lucide="radio" class="w-5 h-5 text-red-600"></i>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <h4 class="text-sm font-semibold text-red-800 mb-1">Signal Required</h4>
                <p class="text-sm text-red-700 leading-relaxed mb-3">
                    You need to purchase the <span class="font-semibold text-red-800">{{ Auth::user()->user_signal }}</span> signal to proceed with trading operations.
                </p>
                <a href="{{ route('signal') }}"
                   class="inline-flex items-center space-x-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                    <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                    <span>Purchase Signal</span>
                </a>
            </div>
        </div>
        <button @click="show = false"
                class="flex-shrink-0 ml-4 p-2 text-red-400 hover:text-red-600 hover:bg-red-500/10 rounded-lg transition-all duration-200">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>
</div>
@endif

<!-- Plan Alert -->
@if(Auth::check() && Auth::user()->plan_status == 'on' && Auth::user()->user_plan_upgade)
<div x-data="{ show: true }"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform translate-y-2"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform translate-y-2"
     class="relative bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 rounded-xl p-5 mb-6 shadow-lg backdrop-blur-sm">
    <div class="flex items-start justify-between">
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-red-500/10 rounded-full flex items-center justify-center">
                    <i data-lucide="trending-up" class="w-5 h-5 text-red-600"></i>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <h4 class="text-sm font-semibold text-red-800 mb-1">Plan Upgrade Required</h4>
                <p class="text-sm text-red-700 leading-relaxed mb-3">
                    To continue and access advanced features, please upgrade to the <span class="font-semibold text-red-800">{{ Auth::user()->user_plan_upgade }}</span>.
                </p>
                <a href="{{ route('mplans') }}"
                   class="inline-flex items-center space-x-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                    <i data-lucide="arrow-up-circle" class="w-4 h-4"></i>
                    <span>Upgrade Plan</span>
                </a>
            </div>
        </div>
        <button @click="show = false"
                class="flex-shrink-0 ml-4 p-2 text-red-400 hover:text-red-600 hover:bg-red-500/10 rounded-lg transition-all duration-200">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>
</div>
@endif
