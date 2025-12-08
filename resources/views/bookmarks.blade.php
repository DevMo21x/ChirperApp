
{{-- filepath: resources/views/bookmarks.blade.php --}}

<x-layout>
    <x-slot:title>
        My Bookmarks
    </x-slot:title>

    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mt-8">My Saved Chirps</h1>
        <p class="text-base-content/60 mt-2">Chirps you've bookmarked for later</p>

        {{-- List of bookmarked chirps --}}
        <div class="mt-8 space-y-4">
            @forelse ($chirps as $chirp)
                <x-chirp :chirp="$chirp" />
            @empty
                {{-- Show this if no bookmarks --}}
                <div class="card bg-base-100 shadow">
                    <div class="card-body text-center">
                        <svg class="w-12 h-12 mx-auto text-base-content/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                        <p class="mt-4 text-base-content/60">No bookmarks yet. Save chirps to see them here!</p>
                        <a href="/" class="btn btn-primary btn-sm mt-4">Browse Chirps</a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>