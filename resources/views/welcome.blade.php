<x-guest-layout>
    <div class="text-center">
        <h1 class="text-3xl font-bold text-emerald-600 mb-2">🌿 MyJobs</h1>
        <p class="text-gray-500 mb-8">Find your perfect remote job, automatically.</p>

        <div class="flex flex-col gap-3">
            @auth
                <a href="{{ route('dashboard') }}"
                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-4 rounded-lg transition">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-4 rounded-lg transition text-center">
                    Log in
                </a>
                <a href="{{ route('register') }}"
                    class="w-full border border-emerald-600 text-emerald-600 hover:bg-emerald-50 font-semibold py-3 px-4 rounded-lg transition text-center">
                    Create account
                </a>
            @endauth
        </div>
    </div>
</x-guest-layout>