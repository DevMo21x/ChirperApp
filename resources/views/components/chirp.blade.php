@props(['chirp'])

<div class="card bg-base-100 shadow">
    <div class="card-body">
        <div class="flex space-x-3">
            @if ($chirp->user)
                <div class="avatar">
                    <div class="size-10 rounded-full">
                        <img src="https://avatars.laravel.cloud/{{ urlencode($chirp->user->email) }}"
                            alt="{{ $chirp->user->name }}'s avatar" class="rounded-full" />
                    </div>
                </div>
            @else
                <div class="avatar placeholder">
                    <div class="size-10 rounded-full">
                        <img src="https://avatars.laravel.cloud/f61123d5-0b27-434c-a4ae-c653c7fc9ed6?vibe=steal"
                            alt="Anonymous User" class="rounded-full" />
                    </div>
                </div>
            @endif

            <div class="min-w-0 flex-1">
                <div class="flex justify-between w-full">
                    <div class="flex items-center gap-1">
                        <span class="text-sm font-semibold">{{ $chirp->user ? $chirp->user->name : 'Anonymous' }}</span>
                        <span class="text-base-content/60">·</span>
                        <span class="text-sm text-base-content/60">{{ $chirp->created_at->diffForHumans() }}</span>
                        @if ($chirp->updated_at->gt($chirp->created_at->addSeconds(5)))
                            <span class="text-base-content/60">·</span>
                            <span class="text-sm text-base-content/60 italic">edited</span>
                        @endif
                    </div>

                    @can('update', $chirp)
                        <div class="flex gap-1">
                            <a href="/chirps/{{ $chirp->id }}/edit" class="btn btn-ghost btn-xs">Edit</a>
                            <form method="POST" action="/chirps/{{ $chirp->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this chirp?')"
                                    class="btn btn-ghost btn-xs text-error">Delete</button>
                            </form>
                        </div>
                    @endcan
                </div>

                <p class="mt-2 text-base">{{ $chirp->message }}</p>

                {{-- ============================================= --}}
                {{-- Like and Bookmark buttons --}}
                {{-- ============================================= --}}
                <div class="flex items-center gap-4 mt-3">

                    {{-- Like Button (existing) --}}
                    <div class="like-container" data-chirp-id="{{ $chirp->id }}">
                        @auth
                            <button type="button" class="btn btn-ghost btn-xs like-btn"
                                data-liked="{{ $chirp->isLikedBy(auth()->user()) ? 'true' : 'false' }}">
                                {{-- Heart icon --}}
                                <svg class="w-4 h-4 inline"
                                    fill="{{ $chirp->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span class="like-count">{{ $chirp->likes->count() }}</span>
                            </button>
                        @else
                            <span class="text-sm text-base-content/60">
                                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                {{ $chirp->likes->count() }}
                            </span>
                        @endauth
                    </div>

                    <div class="bookmark-container" data-chirp-id="{{ $chirp->id }}">
                        @auth
                            <button type="button" class="btn btn-ghost btn-xs bookmark-btn"
                                data-bookmarked="{{ $chirp->isBookmarkedBy(auth()->user()) ? 'true' : 'false' }}">
                                {{-- Bookmark icon --}}
                                <svg class="w-4 h-4 inline"
                                    fill="{{ $chirp->isBookmarkedBy(auth()->user()) ? 'currentColor' : 'none' }}"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                </svg>
                                <span
                                    class="bookmark-text">{{ $chirp->isBookmarkedBy(auth()->user()) ? 'Saved' : 'Save' }}</span>
                            </button>
                        @endauth
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
