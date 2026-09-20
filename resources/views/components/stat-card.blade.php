@props(['label', 'value', 'tone' => 'orange', 'icon'])

@php
$tones = [
    'orange' => 'bg-orange-50 text-orange-600',
    'blue'   => 'bg-blue-50 text-blue-600',
    'green'  => 'bg-green-50 text-green-600',
    'indigo' => 'bg-indigo-50 text-indigo-600',
    'teal'   => 'bg-teal-50 text-teal-600',
    'yellow' => 'bg-yellow-50 text-yellow-600',
    'red'    => 'bg-red-50 text-red-600',
];
@endphp

<div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
    <div class="flex items-center justify-between gap-4">
        <div class="min-w-0">
            <div class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ $label }}</div>
            <div class="mt-1 truncate text-2xl font-bold text-gray-900">{{ $value }}</div>
        </div>
        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg {{ $tones[$tone] }}">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
            </svg>
        </div>
    </div>
</div>