<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Notifications
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if($matches->isEmpty())
                <x-card class="text-center py-12">
                    <div class="text-5xl mb-4">🔔</div>
                    <h3 class="text-lg font-semibold text-gray-600 mb-2">No notifications yet</h3>
                    <p class="text-gray-400 mb-6">Set up your preferences and we'll match jobs for you.</p>
                    <a href="{{ route('preferences.index') }}">
                        <x-button>Set Preferences</x-button>
                    </a>
                </x-card>
            @else
                <div class="grid grid-cols-1 gap-4">
                    @foreach($matches as $match)
                        @if($match->jobListing)
                            <x-card>
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full font-medium">
                                                ✓ Matched
                                            </span>
                                            <span class="text-xs text-gray-400">
                                                {{ $match->created_at->diffForHumans() }}
                                            </span>
                                        </div>

                                        <a href="{{ route('jobs.show', $match->jobListing->id) }}"
                                            class="text-lg font-semibold text-emerald-600 hover:text-emerald-800">
                                            {{ $match->jobListing->title }}
                                        </a>
                                        <p class="text-gray-600 mt-1">{{ $match->jobListing->company }}</p>

                                       <x-job-badges :job="$match->jobListing" />
                                        
                                    </div>

                                    <a href="{{ $match->jobListing->url }}" target="_blank"
                                        class="ml-4 shrink-0 text-sm bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition">
                                        Apply →
                                    </a>
                                </div>
                            </x-card>
                        @endif
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $matches->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>