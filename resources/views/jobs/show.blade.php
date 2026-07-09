<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('jobs.index') }}" class="text-emerald-600 hover:text-emerald-800 text-sm">
                ← Back to Jobs
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                {{-- Header --}}
                <div class="border-b border-gray-100 pb-6 mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">{{ $job->title }}</h1>
                    <p class="text-lg text-emerald-600 font-medium mt-1">{{ $job->company }}</p>

                    <x-job-badges :job="$job" />
                </div>

                {{-- Tags --}}
                @if($job->tags)
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Skills</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($job->tags as $tag)
                                <span class="text-sm bg-gray-50 border border-gray-200 text-gray-600 px-3 py-1 rounded">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Description --}}
                @if($job->description)
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Description</h3>
                        <div class="prose max-w-none text-gray-700 text-sm leading-relaxed">
                            {!! $job->description !!}
                        </div>
                    </div>
                @endif

                {{-- Apply button --}}
                <div class="border-t border-gray-100 pt-6">
                    <a href="{{ $job->url }}" target="_blank"
                        class="inline-block bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-8 rounded-lg transition">
                        Apply Now →
                    </a>
                    <p class="text-xs text-gray-400 mt-2">
                        Posted {{ $job->published_at?->diffForHumans() }} via {{ $job->jobSource?->name }}
                    </p>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>