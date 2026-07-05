<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Jobs
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form method="GET" action="{{ route('jobs.index') }}" class="mb-6" x-data="{ loading: false }" @submit="loading = true">
                <x-card>
                    <div class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm text-gray-600 mb-1">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Job title or company..."
                                class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        </div>
            
                        <div class="flex-1 min-w-[150px]">
                            <label class="block text-sm text-gray-600 mb-1">Location</label>
                            <input type="text" name="location" value="{{ request('location') }}"
                                placeholder="e.g. USA, Europe..."
                                class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        </div>
            
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="remote" id="remote" value="1"
                                {{ request('remote') ? 'checked' : '' }}
                                class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            <label for="remote" class="text-sm text-gray-600">Remote only</label>
                        </div>
            
                        <div class="flex gap-2">
                            <x-button type="submit" x-bind:disabled="loading">
                                <span x-show="!loading">Filter</span>
                                <span x-show="loading" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24" fill="none">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                                    </svg>
                                    Loading...
                                </span>
                            </x-button>
                            @if(request()->anyFilled(['search', 'location', 'remote']))
                                <a href="{{ route('jobs.index') }}">
                                    <x-button class="bg-gray-400 hover:bg-gray-500">Clear</x-button>
                                </a>
                            @endif
                        </div>

                    </div>
                </x-card>
            </form>
            

            @if($jobs->isEmpty())
                <x-alert type="info">No jobs found.</x-alert>
            @else
                <div class="grid grid-cols-1 gap-4">
                    @foreach($jobs as $job)
                        <x-card>
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <a href="{{ route('jobs.show', $job->id) }}"
                                        class="text-lg font-semibold text-emerald-600 hover:text-emerald-800">
                                        {{ $job->title }}
                                    </a>
                                    <p class="text-gray-600 mt-1">{{ $job->company }}</p>

                                    <div class="flex flex-wrap gap-2 mt-3">
                                        @if($job->location)
                                            <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                                                📍 {{ $job->location }}
                                            </span>
                                        @endif

                                        @if($job->is_remote)
                                            <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full">
                                                🌍 Remote
                                            </span>
                                        @endif

                                        @if($job->employment_type)
                                            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">
                                                {{ $job->employment_type }}
                                            </span>
                                        @endif

                                        @if($job->salary_min)
                                            <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full">
                                                💰 ${{ number_format($job->salary_min) }}{{ $job->salary_max ? ' - $' . number_format($job->salary_max) : '+' }}
                                            </span>
                                        @endif
                                    </div>

                                    @if($job->tags)
                                        <div class="flex flex-wrap gap-1 mt-2">
                                            @foreach(array_slice($job->tags, 0, 5) as $tag)
                                                <span class="text-xs bg-gray-50 border border-gray-200 text-gray-500 px-2 py-0.5 rounded">
                                                    {{ $tag }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <div class="text-xs text-gray-400 ml-4 shrink-0">
                                    {{ $job->published_at?->diffForHumans() }}
                                </div>
                            </div>
                        </x-card>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $jobs->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>