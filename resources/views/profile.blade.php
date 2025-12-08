<x-layout>
    <x-slot:title>
        {{ $user->name }}'s Profile
    </x-slot:title>

    <div class="max-w-2xl mx-auto">


        {{-- User Profile Header --}}

        <div class="card bg-base-100 shadow mt-8">
            <div class="card-body">
                <div class="flex items-center gap-4">
                    {{-- User Avatar --}}
                    <div class="avatar">
                        <div class="w-20 rounded-full">
                            <img src="https://avatars.laravel.cloud/{{ urlencode($user->email) }}"
                                alt="{{ $user->name }}'s avatar" />
                        </div>
                    </div>

                    {{-- User Info --}}
                    <div>
                        <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                        <p class="text-base-content/60">Member since {{ $stats['member_since'] }}</p>
                    </div>
                </div>


                {{-- Stats Section --}}

                <div class="stats stats-vertical lg:stats-horizontal shadow mt-6 w-full">

                    {{-- Total Chirps Stat --}}
                    <div class="stat">
                        <div class="stat-figure text-primary">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <div class="stat-title">Total Chirps</div>
                        <div class="stat-value text-primary">{{ $stats['total_chirps'] }}</div>
                        <div class="stat-desc">Messages posted</div>
                    </div>

                    {{-- Total Likes Stat --}}
                    <div class="stat">
                        <div class="stat-figure text-secondary">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <div class="stat-title">Total Likes</div>
                        <div class="stat-value text-secondary">{{ $stats['total_likes'] }}</div>
                        <div class="stat-desc">Likes received</div>
                    </div>

                </div>
            </div>
        </div>


        {{-- User's Chirps --}}

        <h2 class="text-xl font-bold mt-8 mb-4">{{ $user->name }}'s Chirps</h2>

        <div class="space-y-4">
            @forelse ($chirps as $chirp)
                <x-chirp :chirp="$chirp" />
            @empty
                <div class="card bg-base-100 shadow">
                    <div class="card-body text-center">
                        <p class="text-base-content/60">{{ $user->name }} hasn't posted any chirps yet.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>
