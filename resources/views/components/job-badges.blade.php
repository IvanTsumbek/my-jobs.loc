@props(['job'])

<div class="flex flex-wrap gap-2 mt-3">
    @if ($job->location)
        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
            📍 {{ $job->location }}
        </span>
    @endif

    @if ($job->is_remote)
        <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full">
            🌍 Remote
        </span>
    @endif

    @if ($job->employment_type)
        <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">
            {{ $job->employment_type }}
        </span>
    @endif

    @if ($job->category)
        <span class="text-sm bg-purple-100 text-purple-700 px-3 py-1 rounded-full">
            {{ $job->category }}
        </span>
    @endif

    @if ($job->salary_min)
        <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full">
            💰
            ${{ number_format($job->salary_min) }}{{ $job->salary_max ? ' - $' . number_format($job->salary_max) : '+' }}
        </span>
    @endif
</div>
