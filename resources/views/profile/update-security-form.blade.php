<div x-data="{ saving: false }">
    <div class="bg-indigo-50 dark:bg-indigo-900/20 border-l-4 border-indigo-500 p-4 mb-6 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <i data-lucide="bell" class="h-5 w-5 text-indigo-500" aria-hidden="true"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-indigo-700 dark:text-indigo-400">
                    Configure your notification preferences to control what emails you receive from our platform.
                </p>
            </div>
        </div>
    </div>

    <form method="POST" action="javascript:void(0)" id="updateemailpref" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Email Notification Preferences -->
        <div class="space-y-6">
            <!-- OTP Email Setting -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="flex items-start p-5 gap-4">
                    <div class="flex-shrink-0 pt-0.5">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                            <i data-lucide="shield" class="h-5 w-5 text-blue-600 dark:text-blue-400"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">Withdrawal Security</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Send confirmation OTP to my email when withdrawing funds
                        </p>
                    </div>
                    <div class="flex items-center">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center">
                                <input type="radio" id="otpsendYes" name="otpsend" value="Yes"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:checked:bg-blue-600">
                                <label for="otpsendYes" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                    Yes
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="otpsendNo" name="otpsend" value="No"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:checked:bg-blue-600">
                                <label for="otpsendNo" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profit Email Setting -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="flex items-start p-5 gap-4">
                    <div class="flex-shrink-0 pt-0.5">
                        <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                            <i data-lucide="trending-up" class="h-5 w-5 text-green-600 dark:text-green-400"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">Profit Notifications</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Send me email notifications when I receive profit
                        </p>
                    </div>
                    <div class="flex items-center">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center">
                                <input type="radio" id="roiemailYes" name="roiemail" value="Yes"
                                    class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:checked:bg-green-600">
                                <label for="roiemailYes" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                    Yes
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="roiemailNo" name="roiemail" value="No"
                                    class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:checked:bg-green-600">
                                <label for="roiemailNo" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Investment Plan Email Setting -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="flex items-start p-5 gap-4">
                    <div class="flex-shrink-0 pt-0.5">
                        <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                            <i data-lucide="calendar" class="h-5 w-5 text-purple-600 dark:text-purple-400"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">Plan Expiration</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Send me email when my investment plan expires
                        </p>
                    </div>
                    <div class="flex items-center">
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center">
                                <input type="radio" id="invplanemailYes" name="invplanemail" value="Yes"
                                    class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:checked:bg-purple-600">
                                <label for="invplanemailYes" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                    Yes
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="invplanemailNo" name="invplanemail" value="No"
                                    class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:checked:bg-purple-600">
                                <label for="invplanemailNo" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-5">
            <div class="flex justify-end">
                <button
                    type="submit"
                    class="inline-flex items-center px-6 py-3 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                    x-on:click="saving = true"
                    x-bind:disabled="saving"
                >
                    <span x-show="!saving">
                        <i data-lucide="save" class="mr-2 h-5 w-5"></i>
                        Save Preferences
                    </span>
                    <span x-show="saving" style="display: none;">
                        <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>


{{-- This js check is for OTP email --}}
@if (Auth::user()->sendotpemail == 'Yes')
    <script>
        document.getElementById('otpsendYes').checked = true;
    </script>
@else
    <script>
        document.getElementById('otpsendNo').checked = true;
    </script>
@endif

{{-- This js check is for Promotional emails --}}
{{-- @if (Auth::user()->sendpromoemail == 'Yes')
    <script>
        document.getElementById('promotoionlYes').checked = true;
    </script>
@else
<script>
    document.getElementById('promotoionlNo').checked = true;
</script>
@endif --}}

{{-- This js check is for ROI emails --}}
@if (Auth::user()->sendroiemail == 'Yes')
    <script>
        document.getElementById('roiemailYes').checked = true;
    </script>
@else
    <script>
        document.getElementById('roiemailNo').checked = true;
    </script>
@endif

{{-- This js check is for Investmeplan expiration emails --}}
@if (Auth::user()->sendinvplanemail == 'Yes')
    <script>
        document.getElementById('invplanemailYes').checked = true;
    </script>
@else
    <script>
        document.getElementById('invplanemailNo').checked = true;
    </script>
@endif



<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lucide icons if available
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        document.getElementById('updateemailpref').addEventListener('submit', function() {
            const securityApp = Alpine.data('{ saving: true }');

            $.ajax({
                url: "{{ route('updateemail') }}",
                type: 'POST',
                data: $('#updateemailpref').serialize(),
                success: function(response) {
                    if (response.status === 200) {
                        // Show success notification with modern styling
                        const toast = document.createElement('div');
                        toast.className = 'fixed top-4 right-4 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-400 p-4 rounded-lg shadow-lg transform transition-all duration-300 ease-out z-50 flex items-start max-w-sm';
                        toast.innerHTML = `
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium">${response.success}</p>
                            </div>
                            <div class="ml-auto pl-3">
                                <div class="-mx-1.5 -my-1.5">
                                    <button type="button" class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 dark:hover:bg-green-800 focus:outline-none">
                                        <span class="sr-only">Dismiss</span>
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        `;

                        document.body.appendChild(toast);

                        // Add entrance animation
                        setTimeout(() => {
                            toast.classList.add('translate-y-2');
                        }, 10);

                        // Remove the notification after 5 seconds
                        setTimeout(() => {
                            toast.classList.remove('translate-y-2');
                            toast.classList.add('-translate-y-2', 'opacity-0');
                            setTimeout(() => {
                                toast.remove();
                            }, 300);
                        }, 5000);

                        // Add click listener to dismiss button
                        toast.querySelector('button').addEventListener('click', function() {
                            toast.classList.remove('translate-y-2');
                            toast.classList.add('-translate-y-2', 'opacity-0');
                            setTimeout(() => {
                                toast.remove();
                            }, 300);
                        });
                    }

                    // Reset the saving state after 1 second
                    setTimeout(() => {
                        Alpine.store('saving', false);
                    }, 1000);
                },
                error: function(data) {
                    console.log(data);

                    // Reset the saving state
                    Alpine.store('saving', false);

                    // Show error notification
                    const toast = document.createElement('div');
                    toast.className = 'fixed top-4 right-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-400 p-4 rounded-lg shadow-lg transform transition-all duration-300 ease-out z-50 flex items-start max-w-sm';
                    toast.innerHTML = `
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">Failed to update preferences. Please try again.</p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button type="button" class="inline-flex rounded-md p-1.5 text-red-500 hover:bg-red-100 dark:hover:bg-red-800 focus:outline-none">
                                    <span class="sr-only">Dismiss</span>
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    `;

                    document.body.appendChild(toast);

                    // Add entrance animation
                    setTimeout(() => {
                        toast.classList.add('translate-y-2');
                    }, 10);

                    // Remove the notification after 5 seconds
                    setTimeout(() => {
                        toast.classList.remove('translate-y-2');
                        toast.classList.add('-translate-y-2', 'opacity-0');
                        setTimeout(() => {
                            toast.remove();
                        }, 300);
                    }, 5000);
                }
            });
        });
    });
</script>
