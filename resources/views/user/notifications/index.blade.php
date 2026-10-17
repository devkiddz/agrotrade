@extends('layouts.dasht')
@section('title', 'Notifications')

@section('content')
<div x-data="{
  showSuccessAlert: {{ session('success') ? 'true' : 'false' }},
  showErrorAlert: {{ session('error') ? 'true' : 'false' }},
  selectedItems: [],
  selectAll: false,
  filterStatus: 'all',
  searchTerm: ''
}" class="relative px-1 sm:px-2 md:px-3 lg:px-6 xl:px-8 max-w-screen-2xl mx-auto">
  <!-- Gradient Background Effect -->
  <div class="absolute inset-0 bg-gradient-to-br from-primary-50/30 via-transparent to-transparent dark:from-primary-900/10 dark:via-transparent dark:to-transparent rounded-xl -z-10 pointer-events-none"></div>

  <!-- Page Header -->
  <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 px-2">
    <div class="relative">
      <h1 class="text-3xl font-bold text-gray-800 dark:text-white flex items-center">
        <span class="relative">
          Notifications
          <span class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-primary-600 to-primary-300 dark:from-primary-500 dark:to-primary-700"></span>
        </span>
        <span class="ml-2 inline-flex items-center justify-center w-7 h-7 rounded-full bg-primary-100 text-primary-700 text-xs font-medium dark:bg-primary-900/50 dark:text-primary-400">{{ $notifications->total() }}</span>
      </h1>
      <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 max-w-lg">Your personal notification center for staying updated with important system alerts and messages</p>
    </div>

    {{-- <div class="flex flex-wrap items-center gap-3 mt-6 md:mt-0">
      @if(count($notifications) > 0)
        <a href="/mark-all-read" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-600 text-white text-sm font-medium rounded-full transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-primary-500/25 dark:shadow-none">
          <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
          Mark All as Read
        </a>
      @endif
    </div> --}}
  </div>

  <!-- Floating Alert Messages with improved animations -->
  <div class="mb-8 space-y-4 relative z-10">
    <div x-show="showSuccessAlert"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-2"
         class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-900/10 backdrop-blur-sm p-4 rounded-xl shadow-lg border border-green-200/50 dark:border-green-700/30" role="alert">
      <div class="flex items-center">
        <div class="flex-shrink-0 bg-green-100 dark:bg-green-800/50 rounded-full p-1.5">
          <i data-lucide="check-circle" class="h-5 w-5 text-green-600 dark:text-green-400"></i>
        </div>
        <div class="ml-3 flex-1">
          <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
        </div>
        <button @click="showSuccessAlert = false" class="ml-auto flex-shrink-0 p-1.5 rounded-full text-green-500 dark:text-green-400 hover:bg-green-200 dark:hover:bg-green-800/50 transition-colors">
          <i data-lucide="x" class="h-4 w-4"></i>
        </button>
      </div>
    </div>

    <div x-show="showErrorAlert"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-2"
         class="bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/30 dark:to-red-900/10 backdrop-blur-sm p-4 rounded-xl shadow-lg border border-red-200/50 dark:border-red-700/30" role="alert">
      <div class="flex items-center">
        <div class="flex-shrink-0 bg-red-100 dark:bg-red-800/50 rounded-full p-1.5">
          <i data-lucide="alert-circle" class="h-5 w-5 text-red-600 dark:text-red-400"></i>
        </div>
        <div class="ml-3 flex-1">
          <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
        </div>
        <button @click="showErrorAlert = false" class="ml-auto flex-shrink-0 p-1.5 rounded-full text-red-500 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-800/50 transition-colors">
          <i data-lucide="x" class="h-4 w-4"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Filter & Search Bar with glass morphism effect -->
  @if(count($notifications) > 0)
  <div class="mb-8 p-5 backdrop-blur-sm bg-white/70 dark:bg-gray-800/70 rounded-2xl shadow-xl border border-gray-200/50 dark:border-gray-700/50">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-5">
      <div class="flex items-center gap-3">
        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 flex items-center gap-1.5">
          <i data-lucide="filter" class="h-4 w-4 text-gray-500 dark:text-gray-400"></i>
          Filter
        </span>
        <div class="flex rounded-full backdrop-blur-sm bg-gray-100/80 dark:bg-gray-700/80 p-1 overflow-hidden">
          <button @click="filterStatus = 'all'"
                  :class="{'bg-white dark:bg-gray-800 text-primary-700 dark:text-primary-400 shadow-sm font-medium': filterStatus === 'all'}"
                  class="px-4 py-1.5 text-sm transition-all duration-200 rounded-full">
            All
          </button>
          <button @click="filterStatus = 'unread'"
                  :class="{'bg-white dark:bg-gray-800 text-primary-700 dark:text-primary-400 shadow-sm font-medium': filterStatus === 'unread'}"
                  class="px-4 py-1.5 text-sm transition-all duration-200 rounded-full">
            Unread
          </button>
          <button @click="filterStatus = 'read'"
                  :class="{'bg-white dark:bg-gray-800 text-primary-700 dark:text-primary-400 shadow-sm font-medium': filterStatus === 'read'}"
                  class="px-4 py-1.5 text-sm transition-all duration-200 rounded-full">
            Read
          </button>
        </div>
      </div>

      <div class="relative flex-1 max-w-xs ml-auto">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
          <i data-lucide="search" class="h-4 w-4 text-gray-500 dark:text-gray-400"></i>
        </div>
        <input x-model="searchTerm" type="text" id="search" class="pl-10 pr-4 py-2.5 w-full bg-gray-100/80 dark:bg-gray-700/80 border-0 rounded-full text-sm focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-600 transition-all duration-200" placeholder="Search notifications...">
      </div>
    </div>
  </div>
  @endif

  <!-- Notifications List with futuristic design -->
  <div class="backdrop-blur-sm bg-white/70 dark:bg-gray-800/70 rounded-2xl shadow-xl border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
    @if(count($notifications) > 0)
      <div class="overflow-hidden">
        <div class="max-h-[65vh] overflow-y-auto scroll-smooth" id="notifications-container">
          <div class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
            @foreach($notifications as $notification)
              <div x-show="(filterStatus === 'all' || (filterStatus === 'unread' && {{ $notification->is_read ? 'false' : 'true' }}) || (filterStatus === 'read' && {{ $notification->is_read ? 'true' : 'false' }})) &&
                           (searchTerm === '' || '{{ strtolower($notification->title) }}'.includes(searchTerm.toLowerCase()) || '{{ strtolower($notification->message) }}'.includes(searchTerm.toLowerCase()))"
                   x-transition:enter="transition ease-out duration-300"
                   x-transition:enter-start="opacity-0 transform -translate-y-4"
                   x-transition:enter-end="opacity-100 transform translate-y-0"
                   class="group p-5 md:p-6 hover:bg-gray-50/80 dark:hover:bg-gray-700/50 transition-all duration-200 {{ !$notification->is_read ? 'bg-primary-50/50 dark:bg-primary-900/10 border-l-4 border-primary-500 dark:border-primary-600' : '' }}">
                <div class="flex flex-col md:flex-row">
                  <!-- Animated Icon Based on Type -->
                  <div class="flex-shrink-0 mb-4 md:mb-0 transition-transform duration-300 group-hover:scale-110">
                    <div class="flex h-14 w-14 items-center justify-center rounded-full shadow-lg {{
                      $notification->type === 'warning' ? 'bg-gradient-to-br from-yellow-200 to-yellow-100 text-yellow-600 dark:from-yellow-900/40 dark:to-yellow-800/20 dark:text-yellow-500' :
                      ($notification->type === 'success' ? 'bg-gradient-to-br from-green-200 to-green-100 text-green-600 dark:from-green-900/40 dark:to-green-800/20 dark:text-green-500' :
                      ($notification->type === 'danger' ? 'bg-gradient-to-br from-red-200 to-red-100 text-red-600 dark:from-red-900/40 dark:to-red-800/20 dark:text-red-500' :
                      'bg-gradient-to-br from-blue-200 to-blue-100 text-blue-600 dark:from-blue-900/40 dark:to-blue-800/20 dark:text-blue-500')) }}">
                      <i data-lucide="{{ $notification->type === 'warning' ? 'alert-triangle' : ($notification->type === 'success' ? 'check-circle' : ($notification->type === 'danger' ? 'alert-octagon' : 'info')) }}" class="h-7 w-7"></i>
                    </div>
                    @if(!$notification->is_read)
                      <div class="absolute h-3 w-3 rounded-full bg-primary-500 dark:bg-primary-400 ring-2 ring-white dark:ring-gray-800 -mt-2 ml-10"></div>
                    @endif
                  </div>

                  <!-- Notification Content with improved typography -->
                  <div class="md:ml-6 flex-grow">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between">
                      <div class="max-w-2xl">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white leading-tight {{ !$notification->is_read ? 'font-bold' : '' }}">
                          {{ $notification->title }}
                        </h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                          {{ $notification->message }}
                        </p>
                        <div class="mt-3 flex items-center flex-wrap gap-2">
                          <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium shadow-sm {{
                            $notification->type === 'warning' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' :
                            ($notification->type === 'success' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' :
                            ($notification->type === 'danger' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' :
                            'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400')) }}">
                            <i data-lucide="{{ $notification->type === 'warning' ? 'alert-triangle' : ($notification->type === 'success' ? 'check-circle' : ($notification->type === 'danger' ? 'alert-octagon' : 'info')) }}" class="h-3 w-3 mr-1"></i>
                            {{ ucfirst($notification->type) }}
                          </span>
                          <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center">
                            <i data-lucide="clock" class="h-3.5 w-3.5 mr-1"></i>
                            {{ $notification->created_at->diffForHumans() }}
                          </span>
                          <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center">
                            <i data-lucide="{{ $notification->is_read ? 'check-circle-2' : 'circle' }}" class="h-3.5 w-3.5 mr-1 {{ $notification->is_read ? 'text-primary-500 dark:text-primary-400' : '' }}"></i>
                            {{ $notification->is_read ? 'Read' : 'Unread' }}
                          </span>
                        </div>
                      </div>

                      <!-- Modern Action Buttons with hover effects -->
                      <div class="flex items-center mt-4 md:mt-0 space-x-2 opacity-70 group-hover:opacity-100 transition-opacity duration-200">
                        <a href="{{ route('notifications.show', $notification->id) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-gray-100/80 dark:bg-gray-800/80 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-full transition-all duration-200 hover:scale-105 hover:shadow-md">
                          <i data-lucide="eye" class="h-4 w-4 mr-1.5"></i>
                          View
                        </a>

                        @if(!$notification->is_read)
                          <form method="POST" action="{{ route('notifications.mark-read') }}">
                            @csrf
                            <input type="hidden" name="notification_id" value="{{ $notification->id }}">
                            <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-primary-600 dark:text-primary-400 bg-primary-100/80 dark:bg-primary-900/30 hover:bg-primary-200 dark:hover:bg-primary-900/50 rounded-full transition-all duration-200 hover:scale-105 hover:shadow-md">
                              <i data-lucide="check-circle" class="h-4 w-4 mr-1.5"></i>
                              Mark Read
                            </button>
                          </form>
                        @endif

                        <form method="POST" action="{{ route('notifications.delete') }}" x-data="{ confirmDelete: false }">
                          @csrf
                          @method('DELETE')
                          <input type="hidden" name="notification_id" value="{{ $notification->id }}">
                          <button type="button" @click="confirmDelete = true" class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-600 dark:text-red-400 bg-red-50/80 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/40 rounded-full transition-all duration-200 hover:scale-105 hover:shadow-md">
                            <i data-lucide="trash-2" class="h-4 w-4 mr-1.5"></i>
                            Delete
                          </button>

                          <!-- Futuristic Confirmation Modal -->
                          <div x-show="confirmDelete"
                               x-transition:enter="transition ease-out duration-300"
                               x-transition:enter-start="opacity-0 transform scale-95"
                               x-transition:enter-end="opacity-100 transform scale-100"
                               x-transition:leave="transition ease-in duration-200"
                               x-transition:leave-start="opacity-100 transform scale-100"
                               x-transition:leave-end="opacity-0 transform scale-95"
                               class="fixed inset-0 z-50 overflow-y-auto backdrop-blur-sm"
                               x-cloak>
                            <div class="flex items-center justify-center min-h-screen px-4">
                              <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" aria-hidden="true" @click="confirmDelete = false"></div>
                              <div class="relative bg-white/90 dark:bg-gray-800/90 rounded-2xl max-w-md w-full overflow-hidden shadow-2xl border border-gray-200/50 dark:border-gray-700/50 backdrop-blur-md transform transition-all">
                                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 via-red-400 to-red-600"></div>
                                <div class="p-6">
                                  <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-gradient-to-br from-red-100 to-red-50 dark:from-red-900/30 dark:to-red-900/10 p-3 rounded-full">
                                      <i data-lucide="trash-2" class="h-6 w-6 text-red-600 dark:text-red-400"></i>
                                    </div>
                                    <div class="ml-4">
                                      <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Delete Notification</h3>
                                      <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">This action cannot be undone.</p>
                                    </div>
                                  </div>

                                  <div class="mt-5 bg-red-50/50 dark:bg-red-900/10 rounded-xl p-4 border border-red-100 dark:border-red-900/20">
                                    <p class="text-sm text-red-800 dark:text-red-300 flex items-start">
                                      <i data-lucide="alert-circle" class="h-5 w-5 mr-2 flex-shrink-0 text-red-500 dark:text-red-400"></i>
                                      Are you sure you want to permanently delete this notification?
                                    </p>
                                  </div>

                                  <div class="mt-6 flex justify-end space-x-3">
                                    <button @click="confirmDelete = false" type="button" class="px-4 py-2.5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 dark:focus:ring-offset-gray-800">
                                      Cancel
                                    </button>
                                    <button type="submit" class="px-4 py-2.5 rounded-full bg-gradient-to-r from-red-600 to-red-500 text-white text-sm font-medium hover:from-red-500 hover:to-red-600 transition-all duration-200 shadow-lg hover:shadow-red-500/25 dark:shadow-none focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800 transform hover:scale-105">
                                      Delete
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <!-- Modern Pagination with better styling -->
      <div class="px-6 py-4 bg-gradient-to-b from-transparent to-gray-50/80 dark:to-gray-800/50 border-t border-gray-200/50 dark:border-gray-700/50 flex items-center justify-between">
        <div class="flex-1 flex flex-col sm:flex-row sm:items-center sm:justify-between">
          <div class="mb-4 sm:mb-0">
            <p class="text-sm text-gray-600 dark:text-gray-400">
              Showing <span class="font-semibold text-primary-600 dark:text-primary-400">{{ $notifications->firstItem() ?? 0 }}</span> to
              <span class="font-semibold text-primary-600 dark:text-primary-400">{{ $notifications->lastItem() ?? 0 }}</span> of
              <span class="font-semibold text-primary-600 dark:text-primary-400">{{ $notifications->total() }}</span> notifications
            </p>
          </div>
          <div>
            {{ $notifications->onEachSide(1)->links('pagination::tailwind') }}
          </div>
        </div>
      </div>
    @else
      <!-- Empty state with animation -->
      <div class="flex flex-col items-center justify-center py-20 px-4">
        <div class="relative">
          <div class="absolute inset-0 bg-gradient-to-r from-primary-100 to-primary-50 dark:from-primary-900/10 dark:to-primary-800/5 animate-pulse rounded-full blur-xl opacity-70"></div>
          <div class="relative mx-auto flex h-32 w-32 items-center justify-center rounded-full bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 shadow-inner">
            <i data-lucide="bell-off" class="h-16 w-16 text-gray-400 dark:text-gray-500 animate-pulse"></i>
          </div>
        </div>
        <h3 class="mt-8 text-xl font-semibold text-gray-900 dark:text-white">No Notifications</h3>
        <p class="mt-2 text-base text-gray-600 dark:text-gray-300 text-center max-w-md">You don't have any notifications at the moment.</p>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">We'll notify you when something important happens.</p>

        <div class="mt-6">
          <a href="{{ route('dashboard') }}" class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-600 text-white text-sm font-medium rounded-full transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-primary-500/25 dark:shadow-none">
            <i data-lucide="arrow-left" class="h-4 w-4 mr-2"></i>
            Return to Dashboard
          </a>
        </div>
      </div>
    @endif
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide icons
    lucide.createIcons();

    // Add scroll reveal animations to notification items
    const notificationItems = document.querySelectorAll('#notifications-container > div > div');
    let delay = 0;

    notificationItems.forEach((item, index) => {
      // Add slight delay for each item to create cascade effect
      item.style.animationDelay = `${delay}ms`;
      delay += 50; // 50ms delay between each item
    });

    // Auto-dismiss alerts after 6 seconds with fade out
    setTimeout(() => {
      const app = document.querySelector('[x-data]').__x.$data;
      if (app.showSuccessAlert) {
        app.showSuccessAlert = false;
      }
      if (app.showErrorAlert) {
        app.showErrorAlert = false;
      }
    }, 6000);

    // Add smooth scrolling for unread notifications
    const unreadNotification = document.querySelector('.border-l-4.border-primary-500');
    if (unreadNotification && window.location.search.indexOf('highlight=unread') > -1) {
      setTimeout(() => {
        unreadNotification.scrollIntoView({ behavior: 'smooth', block: 'center' });
        unreadNotification.classList.add('animate-pulse');
        setTimeout(() => unreadNotification.classList.remove('animate-pulse'), 2000);
      }, 500);
    }

    // Add hover effects for notifications
    const container = document.getElementById('notifications-container');
    if (container) {
      container.addEventListener('mouseover', function(e) {
        const item = e.target.closest('.group');
        if (item) {
          const siblings = Array.from(document.querySelectorAll('.group'));
          siblings.forEach(sibling => {
            if (sibling !== item) {
              sibling.style.opacity = '0.6';
            }
          });
        }
      });

      container.addEventListener('mouseout', function() {
        const items = document.querySelectorAll('.group');
        items.forEach(item => {
          item.style.opacity = '1';
        });
      });
    }
  });
</script>
@endsection
