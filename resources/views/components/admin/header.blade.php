@props(['title', 'description', 'breadcrumbs' => []])

<header class="w-full flex flex-col gap-4 md:gap-6 sticky top-0 z-40 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-sm border-b border-border-light dark:border-border-dark pb-4 mb-6 md:pb-6 md:pt-4 -mx-6 px-6 md:-mx-8 md:px-8 transition-all">
    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
        <div class="flex flex-col gap-1 md:gap-2">


            <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-[#181811] dark:text-white">{{ $title }}</h2>
            <p class="text-sm md:text-base text-gray-600 dark:text-gray-400 max-w-2xl text-balance">{{ $description }}</p>
        </div>

        <div class="flex items-center gap-3 self-end md:self-auto">
            {{ $actions ?? '' }}
        </div>
    </div>

    @if(isset($stats))
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mt-2">
        {{ $stats }}
    </div>
    @endif
</header>