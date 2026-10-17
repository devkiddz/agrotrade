@extends('layouts.dasht')
@section('title', $title)
@section('content')

<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8" x-data="{ activeTab: 'per' }">
    <div class="container mx-auto px-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Profile Settings</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Manage your account details and security preferences</p>
            </div>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                Back to Dashboard
            </a>
        </div>

        <!-- Alert Messages -->
        <x-danger-alert />
        <x-success-alert />
        <x-error-alert />

        <!-- Breadcrumbs -->
        <nav class="flex mb-6 mt-2" aria-label="Breadcrumb ">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">
                        <i data-lucide="home" class="w-4 h-4 mr-2"></i>
                        Home
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-1"></i>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Profile</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Main Content -->
        <div class="bg-gray-900 dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-700 dark:border-gray-600 overflow-hidden">
            <!-- Profile Header with Avatar -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-12 relative">
                <div class="absolute inset-0 bg-pattern opacity-10"></div>
                <div class="flex flex-col items-center relative z-10">
                    <div class="relative group">
                        <div class="w-24 h-24 rounded-full bg-white dark:bg-gray-700 p-1 shadow-lg">
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="rounded-full w-full h-full object-cover">
                        </div>
                        <div class="absolute inset-0 rounded-full flex items-center justify-center bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                            <i data-lucide="camera" class="w-6 h-6 text-white"></i>
                        </div>
                    </div>
                    <h2 class="text-xl font-bold text-white mt-4">{{ Auth::user()->name }}</h2>
                    <p class="text-blue-100">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="border-b border-gray-700 dark:border-gray-600">
                <div class="flex px-6">
                    <button @click="activeTab = 'per'" :class="{ 'border-b-2 border-blue-500': activeTab === 'per', 'text-blue-600 dark:text-blue-400': activeTab === 'per', 'text-gray-300 dark:text-gray-400': activeTab !== 'per' }" class="py-4 px-4 font-medium text-sm focus:outline-none flex items-center gap-2 transition-colors">
                        <i data-lucide="user" class="w-5 h-5"></i>
                        <span>Personal Information</span>
                    </button>
                    <button @click="activeTab = 'pas'" :class="{ 'border-b-2 border-blue-500': activeTab === 'pas', 'text-blue-600 dark:text-blue-400': activeTab === 'pas', 'text-gray-300 dark:text-gray-400': activeTab !== 'pas' }" class="py-4 px-4 font-medium text-sm focus:outline-none flex items-center gap-2 transition-colors">
                        <i data-lucide="lock" class="w-5 h-5"></i>
                        <span>Security</span>
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                <div x-show="activeTab === 'per'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 mb-6 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i data-lucide="info" class="h-5 w-5 text-blue-500" aria-hidden="true"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700 dark:text-blue-400">
                                    Your personal information helps us personalize your experience. Please ensure all details are accurate and up-to-date.
                                </p>
                            </div>
                        </div>
                    </div>
                    @include('profile.update-profile-information-form')
                </div>

                <div x-show="activeTab === 'pas'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" style="display: none;">
                    <div class="bg-indigo-50 dark:bg-indigo-900/20 border-l-4 border-indigo-500 p-4 mb-6 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i data-lucide="shield" class="h-5 w-5 text-indigo-500" aria-hidden="true"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-indigo-700 dark:text-indigo-400">
                                    Strong passwords help protect your account. Use a unique password that includes numbers, letters, and special characters.
                                </p>
                            </div>
                        </div>
                    </div>
                    @include('profile.update-password-form')
                </div>
            </div>
        </div>

        <!-- Activity Card -->
        <div class="bg-gray-900 dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-700 dark:border-gray-600 mt-8 p-6">
            <div class="flex items-center gap-4 mb-6">
                <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                    <i data-lucide="activity" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white dark:text-white">Recent Activity</h2>
                    <p class="text-sm text-gray-300 dark:text-gray-400">Latest actions on your account</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-800 dark:bg-gray-700/50 border border-gray-700 dark:border-gray-600">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                        <i data-lucide="log-in" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-white dark:text-white">Account Login</p>
                        <p class="text-xs text-gray-300 dark:text-gray-400">Last login from {{ request()->ip() }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-medium text-gray-300 dark:text-gray-400">{{ \Carbon\Carbon::now()->subMinutes(rand(5, 120))->diffForHumans() }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-800 dark:bg-gray-700/50 border border-gray-700 dark:border-gray-600">
                    <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-full">
                        <i data-lucide="settings" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-white dark:text-white">Profile Updated</p>
                        <p class="text-xs text-gray-300 dark:text-gray-400">You updated your profile information</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-medium text-gray-300 dark:text-gray-400">
                            {{Auth::user()->updated_at->toDayDateTimeString()}}
                            </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    @parent
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Add this style for the background pattern
            const style = document.createElement('style');
            style.textContent = `
                .bg-pattern {
                    background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
                }
            `;
            document.head.appendChild(style);
        });
    </script>
@endsection
