<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Preferences
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
            @endif

            <x-card>
                <form method="POST" action="{{ route('preferences.save') }}">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Keywords
                            <span class="text-gray-400 font-normal">(comma separated, e.g. PHP, Laravel, Vue)</span>
                        </label>
                        <input type="text" name="keywords"
                            value="{{ $preference ? implode(', ', $preference->keywords ?? []) : '' }}"
                            placeholder="PHP, Laravel, Vue..."
                            class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                        @error('keywords')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Locations
                            <span class="text-gray-400 font-normal">(comma separated, e.g. remote, EU, USA)</span>
                        </label>
                        <input type="text" name="locations"
                            value="{{ $preference ? implode(', ', $preference->locations ?? []) : '' }}"
                            placeholder="remote, EU, USA..."
                            class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Categories
                            <span class="text-gray-400 font-normal">(comma separated)</span>
                        </label>
                        <input type="text" name="categories"
                            value="{{ $preference ? implode(', ', $preference->categories ?? []) : '' }}"
                            placeholder="Software Development, DevOps..."
                            class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Salary Min ($)</label>
                            <input type="number" name="salary_min" value="{{ $preference?->salary_min }}"
                                placeholder="50000"
                                class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Salary Max ($)</label>
                            <input type="number" name="salary_max" value="{{ $preference?->salary_max }}"
                                placeholder="150000"
                                class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Frequency</label>
                            <select name="frequency"
                                class="rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="daily"
                                    {{ ($preference?->frequency ?? 'daily') === 'daily' ? 'selected' : '' }}>Daily
                                </option>
                                <option value="weekly" {{ $preference?->frequency === 'weekly' ? 'selected' : '' }}>
                                    Weekly</option>
                            </select>
                        </div>

                        <label class="flex items-center gap-3 cursor-pointer">
                            <span class="text-sm font-medium text-gray-700">Remote only</span>
                            <div class="relative">
                                <input type="checkbox" name="remote_only" value="1"
                                    {{ $preference?->remote_only ? 'checked' : '' }} class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-emerald-500 rounded-full peer peer-checked:bg-emerald-600 transition">
                                </div>
                                <div
                                    class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition peer-checked:translate-x-5">
                                </div>
                            </div>
                        </label>
                    </div>

                    <x-button type="submit">Save Preferences</x-button>
                </form>
            </x-card>

            @if ($preference)
                <x-card class="mt-6">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Current Settings</h3>

                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Keywords</p>
                            <div class="flex flex-wrap gap-1 mt-1">
                                @forelse($preference->keywords ?? [] as $keyword)
                                    <span
                                        class="bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded text-xs">{{ $keyword }}</span>
                                @empty
                                    <span class="text-gray-400">—</span>
                                @endforelse
                            </div>
                        </div>

                        <div>
                            <p class="text-gray-500">Locations</p>
                            <div class="flex flex-wrap gap-1 mt-1">
                                @forelse($preference->locations ?? [] as $location)
                                    <span
                                        class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-xs">{{ $location }}</span>
                                @empty
                                    <span class="text-gray-400">—</span>
                                @endforelse
                            </div>
                        </div>

                        <div>
                            <p class="text-gray-500">Salary</p>
                            <p class="font-medium text-gray-700 mt-1">
                                @if ($preference->salary_min || $preference->salary_max)
                                    ${{ number_format($preference->salary_min ?? 0) }} —
                                    ${{ number_format($preference->salary_max ?? 0) }}
                                @else
                                    —
                                @endif
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">Frequency</p>
                            <p class="font-medium text-gray-700 mt-1">{{ ucfirst($preference->frequency ?? '—') }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500">Remote only</p>
                            <p class="font-medium mt-1">
                                @if ($preference->remote_only)
                                    <span class="text-emerald-600">✓ Yes</span>
                                @else
                                    <span class="text-gray-400">No</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </x-card>
            @endif

        </div>
    </div>
</x-app-layout>
