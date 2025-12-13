@props(['color' => 'neutral', 'label', 'icon' => null])

@php
$colors = [
'primary' => 'bg-primary/20 text-black dark:text-white border border-primary/40',
'success' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-200',
'warning' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300 border border-amber-200',
'error' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-300 border border-rose-200',
'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-200',
'neutral' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300 border border-gray-200',
'orange' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300 border border-orange-200',
];

$classes = $colors[$color] ?? $colors['neutral'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold $classes"]) }}>
    @if($icon)
    <span class="material-symbols-outlined text-[14px]">{{ $icon }}</span>
    @else
    <span class="w-1.5 h-1.5 rounded-full bg-current opacity-75"></span>
    @endif
    {{ $label }}
</span>