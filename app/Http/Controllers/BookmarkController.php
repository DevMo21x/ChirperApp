<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
  
    public function store(Request $request, Chirp $chirp)
    {
        // Only create bookmark if user hasn't already bookmarked it
        if (!$chirp->isBookmarkedBy(auth()->user())) {
            $chirp->bookmarks()->create([
                'user_id' => auth()->id(),
            ]);
        }

        // If request is AJAX, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'bookmarked' => true,
                'count' => $chirp->bookmarks()->count()
            ]);
        }


        return back()->with('success', 'Chirp bookmarked!');
    }

   
    public function destroy(Request $request, Chirp $chirp)
    {
        // Find and delete the bookmark for current user
        $chirp->bookmarks()->where('user_id', auth()->id())->delete();

        // If request is AJAX, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'bookmarked' => false,
                'count' => $chirp->bookmarks()->count()
            ]);
        }


        return back()->with('success', 'Bookmark removed!');
    }


    public function index()
    {
        // Get all chirps that the current user has bookmarked
        $chirps = auth()->user()->bookmarkedChirps()
            ->with('user', 'likes', 'bookmarks')
            ->latest()
            ->get();

        return view('bookmarks', ['chirps' => $chirps]);
    }
}
