<!DOCTYPE html>
<html lang="en" data-theme="lofi">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ isset($title) ? $title . ' - Chirper' : 'Chirper' }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
        <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="min-h-screen flex flex-col bg-base-200 font-sans">
        <nav class="navbar bg-base-100">
            <div class="navbar-start">
                <a href="/" class="btn btn-ghost text-xl">🐦 Chirper</a>
            </div>

            <div class="navbar-end gap-2">
                {{-- Theme Toggle Button --}}
                <button id="theme-toggle" class="btn btn-ghost btn-circle">
                    <svg id="sun-icon" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <svg id="moon-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                @auth
                    {{-- NEW: Bookmarks link for logged-in users --}}
                    <a href="{{ route('bookmarks.index') }}" class="btn btn-ghost btn-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                        Bookmarks
                    </a>

                    <span class="text-sm">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="btn btn-ghost btn-sm">Logout</button>
                    </form>
                @else
                    <a href="/login" class="btn btn-ghost btn-sm">Sign In</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Sign Up</a>
                @endauth
            </div>
        </nav>

        {{-- Success Toast --}}
        @if (session('success'))
            <div class="toast toast-top toast-center">
                <div class="alert alert-success animate-fade-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <main class="flex-1 container mx-auto px-4 py-8">
            {{ $slot }}
        </main>

        <footer class="footer footer-center p-5 bg-base-300 text-base-content text-xs">
            <div>
                <p>© 2025 Chirper - Built with Laravel and ❤️</p>
            </div>
        </footer>
    </body>

</html>
