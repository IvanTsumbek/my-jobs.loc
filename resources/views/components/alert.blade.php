@props(['type' => 'info'])

@php
$styles = [
    'info'    => 'bg-blue-50 text-blue-700 border-blue-200',
    'success' => 'bg-green-50 text-green-700 border-green-200',
    'error'   => 'bg-red-50 text-red-700 border-red-200',
];
@endphp

<div {{ $attributes->merge(['class' => 'border rounded-md p-4 ' . $styles[$type]]) }}>
    {{ $slot }}
</div>