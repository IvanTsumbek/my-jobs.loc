<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <p class="text-gray-600 mb-8">Welcome back, <span class="font-semibold text-emerald-600">{{ auth()->user()->name }}</span> 👋</p>

            {{-- Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                <x-card class="flex items-center gap-4">
                    <div class="bg-emerald-100 text-emerald-600 rounded-full p-4 text-2xl">💼</div>
                    <div>
                        <p class="text-sm text-gray-500">Total Jobs</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $jobsCount }}</p>
                    </div>
                </x-card>

                <x-card class="flex items-center gap-4">
                    <div class="bg-blue-100 text-blue-600 rounded-full p-4 text-2xl">🔔</div>
                    <div>
                        <p class="text-sm text-gray-500">Your Matches</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $matchesCount }}</p>
                    </div>
                </x-card>

                <x-card class="flex items-center gap-4">
                    <div class="bg-purple-100 text-purple-600 rounded-full p-4 text-2xl">🔄</div>
                    <div>
                        <p class="text-sm text-gray-500">Last Sync</p>
                        <p class="text-sm font-semibold text-gray-800">
                            @if($lastFetch)
                                {{ $lastFetch->finished_at?->diffForHumans() }}
                                <span class="block text-xs {{ $lastFetch->status === 'success' ? 'text-emerald-500' : 'text-red-500' }}">
                                    {{ $lastFetch->status }}
                                </span>
                            @else
                                —
                            @endif
                        </p>
                    </div>
                </x-card>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Recent matches --}}
                <div class="lg:col-span-2">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Recent Matches</h3>

                    @if($recentMatches->isEmpty())
                        <x-card class="text-center py-8">
                            <p class="text-gray-400">No matches yet.</p>
                            <a href="{{ route('preferences.index') }}" class="text-emerald-600 text-sm underline mt-2 inline-block">
                                Set up preferences
                            </a>
                        </x-card>
                    @else
                        <div class="grid grid-cols-1 gap-3">
                            @foreach($recentMatches as $match)
                                @if($match->jobListing)
                                    <x-card>
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <a href="{{ route('jobs.show', $match->jobListing->id) }}"
                                                    class="font-semibold text-emerald-600 hover:text-emerald-800 text-sm">
                                                    {{ $match->jobListing->title }}
                                                </a>
                                                <p class="text-xs text-gray-500 mt-0.5">{{ $match->jobListing->company }}</p>
                                            </div>
                                            <span class="text-xs text-gray-400">{{ $match->created_at->diffForHumans() }}</span>
                                        </div>
                                    </x-card>
                                @endif
                            @endforeach
                        </div>

                        <a href="{{ route('notifications.index') }}" class="text-emerald-600 text-sm underline mt-3 inline-block">
                            View all →
                        </a>
                    @endif
                </div>

                {{-- Quick actions --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Quick Actions</h3>
                    <x-card>
                        <div class="flex flex-col gap-3">
                            <a href="{{ route('jobs.index') }}">
                                <x-button class="w-full justify-center">Browse Jobs</x-button>
                            </a>
                            <a href="{{ route('preferences.index') }}">
                                <x-button class="w-full justify-center bg-gray-600 hover:bg-gray-700">My Preferences</x-button>
                            </a>
                            <a href="{{ route('notifications.index') }}">
                                <x-button class="w-full justify-center bg-blue-600 hover:bg-blue-700">Notifications</x-button>
                            </a>
                        </div>
                    </x-card>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>