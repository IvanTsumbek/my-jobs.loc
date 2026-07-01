<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <p class="text-gray-600 mb-8">Welcome back, <span class="font-semibold text-emerald-600">{{ auth()->user()->name }}</span> 👋</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

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

            </div>

            <div class="mt-8 flex gap-4">
                <a href="{{ route('jobs.index') }}">
                    <x-button>Browse Jobs</x-button>
                </a>
                <a href="{{ route('preferences.index') }}">
                    <x-button class="bg-gray-600 hover:bg-gray-700">My Preferences</x-button>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>