@props(['active' => false])

@php
$classes = ($active ?? false)
            ? 'bg-amber-50 border-amber-500 text-amber-700 group flex items-center px-3 py-2 text-sm font-medium border-l-4'
            : 'border-transparent text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-3 py-2 text-sm font-medium border-l-4';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>