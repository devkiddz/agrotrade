@props([
    'title' => '',
    'icon' => '',
    'value' => '',
    'color' => 'bg-white',
])

<div class="rounded-2xl shadow-sm p-6 {{ $color }} text-gray-900 dark:text-white transition">
    <div class="flex items-center justify-between">
        <div>
            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $title }}</h4>
            <p class="text-2xl font-bold mt-1">{{ $value }}</p>
        </div>
        <div class="text-3xl text-primary-600 dark:text-primary-400">
            {!! $icon !!}
        </div>
    </div>
</div>
