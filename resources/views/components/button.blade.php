@props(['type' => 'button', 'variant' => 'primary'])

@php
$styles = [
    'primary' => 'bg-emerald-600 hover:bg-emerald-700 text-white',
    'secondary' => 'bg-gray-600 hover:bg-gray-700 text-white',
    'outline' => 'border border-emerald-600 text-emerald-600 hover:bg-emerald-50',
    'danger' => 'bg-red-600 hover:bg-red-700 text-white',
];
$base = 'inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed';
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $base . ' ' . ($styles[$variant] ?? $styles['primary'])]) }}>
    {{ $slot }}
</button>