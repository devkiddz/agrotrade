<div x-data="{ showOldPassword: false, showNewPassword: false, showConfirmPassword: false, passwordStrength: 0, passwordFeedback: '' }" class="space-y-8">
    <!-- Password Introduction -->
    <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 mb-6 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <i data-lucide="lock" class="h-5 w-5 text-blue-500" aria-hidden="true"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700 dark:text-blue-400">
                    Updating your password regularly helps keep your account secure. Create a strong password that you don't use elsewhere.
                </p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{route('updateuserpass')}}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Password Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Current Password -->
            <div class="space-y-2">
                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Current Password
                </label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-lucide="key" class="h-5 w-5 text-gray-400"></i>
                    </div>
                    <input
                        type="password"
                        name="current_password"
                        id="current_password"
                        :type="showOldPassword ? 'text' : 'password'"
                        class="pl-10 pr-10 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm py-4"
                        required
                        placeholder="Enter current password"
                    >
                    <div class="absolute inset-y-0 right-0 flex items-center px-3">
                        <button
                            type="button"
                            @click="showOldPassword = !showOldPassword"
                            class="text-gray-400 hover:text-gray-500 focus:outline-none"
                        >
                            <i data-lucide="eye" class="h-5 w-5" x-show="!showOldPassword"></i>
                            <i data-lucide="eye-off" class="h-5 w-5" x-show="showOldPassword" style="display: none;"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- New Password -->
            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    New Password
                </label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-lucide="lock" class="h-5 w-5 text-gray-400"></i>
                    </div>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        :type="showNewPassword ? 'text' : 'password'"
                        class="pl-10 pr-10 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm py-4"
                        required
                        placeholder="Enter new password"
                        @input="checkPasswordStrength($event.target.value)"
                    >
                    <div class="absolute inset-y-0 right-0 flex items-center px-3">
                        <button
                            type="button"
                            @click="showNewPassword = !showNewPassword"
                            class="text-gray-400 hover:text-gray-500 focus:outline-none"
                        >
                            <i data-lucide="eye" class="h-5 w-5" x-show="!showNewPassword"></i>
                            <i data-lucide="eye-off" class="h-5 w-5" x-show="showNewPassword" style="display: none;"></i>
                        </button>
                    </div>
                </div>

                <!-- Password Strength Meter -->
                <div class="mt-2">
                    <div class="flex items-center justify-between mb-1">
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400" x-text="passwordFeedback"></div>
                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400">Password Strength</div>
                    </div>
                    <div class="h-1.5 w-full bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div
                            class="h-full transition-all duration-300 ease-out rounded-full"
                            :class="{
                                'bg-red-500': passwordStrength > 0 && passwordStrength < 33,
                                'bg-yellow-500': passwordStrength >= 33 && passwordStrength < 66,
                                'bg-green-500': passwordStrength >= 66
                            }"
                            :style="'width: ' + passwordStrength + '%'"
                        ></div>
                    </div>
                </div>
            </div>

            <!-- Confirm New Password -->
            <div class="space-y-2">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Confirm New Password
                </label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-lucide="check-circle" class="h-5 w-5 text-gray-400"></i>
                    </div>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        :type="showConfirmPassword ? 'text' : 'password'"
                        class="pl-10 pr-10 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm py-4"
                        required
                        placeholder="Confirm new password"
                    >
                    <div class="absolute inset-y-0 right-0 flex items-center px-3">
                        <button
                            type="button"
                            @click="showConfirmPassword = !showConfirmPassword"
                            class="text-gray-400 hover:text-gray-500 focus:outline-none"
                        >
                            <i data-lucide="eye" class="h-5 w-5" x-show="!showConfirmPassword"></i>
                            <i data-lucide="eye-off" class="h-5 w-5" x-show="showConfirmPassword" style="display: none;"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Button -->
        <div class="pt-4">
            <button
                type="submit"
                class="inline-flex items-center px-6 py-4 border border-transparent rounded-xl shadow-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
            >
                <i data-lucide="save" class="mr-2 h-5 w-5"></i>
                Update Password
            </button>
        </div>
    </form>
</div>

<!-- Password Requirements Card -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm mt-8">
    <div class="p-5">
        <div class="flex items-center gap-3 mb-4">
            <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                <i data-lucide="shield-check" class="h-5 w-5 text-indigo-600 dark:text-indigo-400"></i>
            </div>
            <h3 class="text-base font-medium text-gray-900 dark:text-white">Password Requirements</h3>
        </div>

        <div class="space-y-3 pl-2">
            <div class="flex items-start">
                <div class="flex-shrink-0 mt-0.5">
                    <i data-lucide="check-circle" class="h-5 w-5 text-green-500"></i>
                </div>
                <p class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                    Minimum 8 characters long - the more, the better
                </p>
            </div>

            <div class="flex items-start">
                <div class="flex-shrink-0 mt-0.5">
                    <i data-lucide="check-circle" class="h-5 w-5 text-green-500"></i>
                </div>
                <p class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                    At least one lowercase character
                </p>
            </div>

            <div class="flex items-start">
                <div class="flex-shrink-0 mt-0.5">
                    <i data-lucide="check-circle" class="h-5 w-5 text-green-500"></i>
                </div>
                <p class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                    At least one uppercase character
                </p>
            </div>

            <div class="flex items-start">
                <div class="flex-shrink-0 mt-0.5">
                    <i data-lucide="check-circle" class="h-5 w-5 text-green-500"></i>
                </div>
                <p class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                    At least one number or special symbol
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lucide icons if available
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Add Alpine function for password strength
        if (typeof Alpine !== 'undefined') {
            Alpine.data('passwordStrength', () => ({
                checkPasswordStrength(password) {
                    if (!password) {
                        this.passwordStrength = 0;
                        this.passwordFeedback = '';
                        return;
                    }

                    let strength = 0;

                    // Length check
                    if (password.length >= 8) strength += 25;

                    // Character variety checks
                    if (password.match(/[a-z]+/)) strength += 25; // lowercase
                    if (password.match(/[A-Z]+/)) strength += 25; // uppercase
                    if (password.match(/[0-9]+/) || password.match(/[^a-zA-Z0-9]+/)) strength += 25; // numbers or symbols

                    this.passwordStrength = strength;

                    // Set feedback based on strength
                    if (strength < 25) {
                        this.passwordFeedback = 'Very Weak';
                    } else if (strength < 50) {
                        this.passwordFeedback = 'Weak';
                    } else if (strength < 75) {
                        this.passwordFeedback = 'Moderate';
                    } else {
                        this.passwordFeedback = 'Strong';
                    }
                }
            }));
        }
    });
</script>
