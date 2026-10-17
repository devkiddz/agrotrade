@if ($errors->any())
    <div class="fixed top-4 left-1/2 transform -translate-x-1/2 w-[90%] max-w-xl z-50">
        <div class="rounded-xl bg-red-50 border border-red-200 shadow-lg px-5 py-4 relative">
            <div class="flex items-start space-x-3">
                <!-- Error icon -->
                <svg 
    style="width: 24px; height: 24px; color: #ef4444; margin-top: 4px;" 
    xmlns="http://www.w3.org/2000/svg" 
    fill="none" 
    viewBox="0 0 24 24" 
    stroke="currentColor"
>
    <path 
        stroke-linecap="round" 
        stroke-linejoin="round" 
        stroke-width="2" 
        d="M18.364 5.636l-12.728 12.728M5.636 5.636l12.728 12.728" 
    />
</svg>

                <div class="text-sm text-red-700">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

                <!-- Close button -->
                <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600 transition">
                   <svg 
    xmlns="http://www.w3.org/2000/svg" 
    style="width: 20px; height: 20px; color: currentColor;" 
    viewBox="0 0 20 20" 
    fill="currentColor"
>
    <path 
        fill-rule="evenodd" 
        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" 
        clip-rule="evenodd" 
    />
</svg>

                </button>
            </div>
        </div>
    </div>
@endif
