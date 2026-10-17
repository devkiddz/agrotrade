@extends('layouts.app')
@section('content')

<div class="container-fluid px-6 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $title }}</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Manage expert traders and copy trading system</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.copy.statistics') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg font-medium hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">
                <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                Statistics
            </a>
            <a href="{{ route('admin.copy.active-trades') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-lg font-medium hover:bg-green-200 dark:hover:bg-green-900/50 transition-colors">
                <i data-lucide="activity" class="w-4 h-4"></i>
                Active Trades
            </a>
            <a href="{{ route('admin.copy.create') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors shadow-lg hover:shadow-xl">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Add Expert
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-300 rounded-lg">
            <div class="flex items-center">
                <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-300 rounded-lg">
            <div class="flex items-center">
                <i data-lucide="alert-circle" class="w-5 h-5 mr-2"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Experts Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Expert Traders</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Manage all expert traders in the system</p>
        </div>

        @if($experts->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white text-sm">Expert</th>
                            <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white text-sm">Performance</th>
                            <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white text-sm">Followers</th>
                            <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white text-sm">Min Investment</th>
                            <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white text-sm">Status</th>
                            <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white text-sm">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($experts as $expert)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <!-- Expert Info -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-4">
                                        @if($expert->photo)
                                            <img src="{{ asset('storage/' . $expert->photo) }}" 
                                                 class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600"
                                                 alt="{{ $expert->name }}">
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                                                {{ substr($expert->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ $expert->name }}</h3>
                                            @if($expert->tag)
                                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $expert->tag }}</p>
                                            @endif
                                            <div class="flex items-center gap-1 mt-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $expert->rating)
                                                        <i data-lucide="star" class="w-3 h-3 text-yellow-400 fill-current"></i>
                                                    @else
                                                        <i data-lucide="star" class="w-3 h-3 text-gray-300 dark:text-gray-600"></i>
                                                    @endif
                                                @endfor
                                                <span class="ml-1 text-xs text-gray-600 dark:text-gray-400">({{ $expert->rating }})</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Performance -->
                                <td class="py-4 px-6">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $expert->win_rate }}% Win Rate</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm text-green-600 dark:text-green-400">+{{ number_format((float)$expert->total_profit, 1) }}% Profit</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs text-gray-600 dark:text-gray-400">{{ number_format($expert->total_trades) }} trades</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs text-gray-600 dark:text-gray-400">${{ number_format((float)$expert->equity) }} equity</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Followers -->
                                <td class="py-4 px-6">
                                    <div class="text-center">
                                        <div class="text-lg font-bold text-gray-900 dark:text-white">{{ number_format($expert->followers) }}</div>
                                        <div class="text-xs text-gray-600 dark:text-gray-400">Total</div>
                                        @if($expert->active_copiers_count > 0)
                                            <div class="text-xs text-green-600 dark:text-green-400 mt-1">{{ $expert->active_copiers_count }} active</div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Min Investment -->
                                <td class="py-4 px-6">
                                    <span class="text-lg font-semibold text-gray-900 dark:text-white">${{ number_format((float)$expert->price, 2) }}</span>
                                </td>

                                <!-- Status -->
                                <td class="py-4 px-6">
                                    @if($expert->status === 'active')
                                        <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-lg text-xs font-medium">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg text-xs font-medium">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.copy.edit', $expert->id) }}"
                                           class="p-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors"
                                           title="Edit">
                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                        </a>
                                        
                                        @if($expert->active_copiers_count == 0)
                                            <button onclick="deleteExpert({{ $expert->id }})"
                                                    class="p-2 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors"
                                                    title="Delete">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        @else
                                            <span class="p-2 bg-gray-100 dark:bg-gray-700 text-gray-400 rounded-lg cursor-not-allowed"
                                                  title="Cannot delete - has active copiers">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="users" class="w-8 h-8 text-gray-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No Expert Traders</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Get started by adding your first expert trader to the system.
                </p>
                <a href="{{ route('admin.copy.create') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Add First Expert
                </a>
            </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function deleteExpert(expertId) {
            Swal.fire({
                title: 'Delete Expert Trader?',
                text: 'This action cannot be undone. The expert trader will be permanently removed.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'bg-red-600 hover:bg-red-700 text-white rounded-xl px-6 py-2',
                    cancelButton: 'bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-xl px-6 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ route('admin.copy.destroy', '') }}/${expertId}`;
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    form.appendChild(methodField);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Initialize Lucide icons
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
@endsection
