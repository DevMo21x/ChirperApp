<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    // Show a user's profile with their stats

    public function show(User $user)
    {
        // Get the user's chirps with likes
        $chirps = $user->chirps()->with('user', 'likes', 'bookmarks')->latest()->get();

        // Calculate stats
        $stats = [
            // Total number of chirps by this user
            'total_chirps' => $user->chirps()->count(),

            // Total likes received on all their chirps
            'total_likes' => $user->chirps()->withCount('likes')->get()->sum('likes_count'),

            // When they joined
            'member_since' => $user->created_at->format('M Y'),
        ];

        return view('profile', [
            'user' => $user,
            'chirps' => $chirps,
            'stats' => $stats,
        ]);
    }
}
