@if (Session::has('success'))
    <div class="flex justify-center mt-4">
        <div class="w-full max-w-2xl px-4">
            <div class="bg-green-100 border border-green-400 text-green-800 rounded-xl p-4 flex items-start space-x-4 shadow-md relative">
                <!-- Icon -->
                <div class="pt-1">
                   <svg 
    style="width: 24px; height: 24px; color: #16a34a;" 
    fill="none" 
    stroke="currentColor" 
    stroke-width="2" 
    viewBox="0 0 24 24" 
    xmlns="http://www.w3.org/2000/svg"
>
    <path 
        stroke-linecap="round" 
        stroke-linejoin="round" 
        d="M5 13l4 4L19 7"
    />
</svg>

                </div>

                <!-- Message -->
                <div class="flex-1 text-sm font-medium">
                    {{ Session::get('success') }}
                </div>

                <!-- Close button -->
                <button type="button"
                        class="absolute top-2 right-2 text-green-600 hover:text-green-800 focus:outline-none"
                        onclick="this.parentElement.remove();">
                    <svg 
    style="width: 20px; height: 20px; color: currentColor;" 
    fill="none" 
    stroke="currentColor" 
    stroke-width="2" 
    viewBox="0 0 24 24" 
    xmlns="http://www.w3.org/2000/svg"
>
    <path 
        stroke-linecap="round" 
        stroke-linejoin="round" 
        d="M6 18L18 6M6 6l12 12"
    />
</svg>

                </button>
            </div>
        </div>
    </div>
@endif
