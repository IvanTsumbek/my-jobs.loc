@props(['type' => 'info'])

@php
$styles = [
    'info'    => 'bg-blue-50 text-blue-700 border-blue-200',
    'success' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
    'error'   => 'bg-red-50 text-red-700 border-red-200',
    'warning' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
];

$icons = [
    'info'    => 'ℹ️',
    'success' => '✓',
    'error'   => '✕',
    'warning' => '⚠️',
];
@endphp

<div {{ $attributes->merge(['class' => 'border rounded-lg p-4 flex items-start gap-3 ' . ($styles[$type] ?? $styles['info'])]) }}>
    <span>{{ $icons[$type] ?? '' }}</span>
    <div>{{ $slot }}</div>
</div>