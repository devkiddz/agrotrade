<div>
    @if (Session::has('message'))
        <div class="max-w-3xl mx-auto px-4">
            <div class="flex items-start p-4 rounded-xl bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-100 shadow-md relative" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-3 mt-1 text-red-600 dark:text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2v6m0-10a9 9 0 110 18 9 9 0 010-18z" />
                </svg>
                <div class="flex-1">
                    <p class="text-sm font-medium">{{ Session::get('message') }}</p>
                </div>
                <button type="button" class="ml-4 text-red-700 hover:text-red-900 dark:text-red-300 dark:hover:text-white transition" onclick="this.parentElement.remove();">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif
</div>
