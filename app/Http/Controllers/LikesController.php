<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Chirp;

class LikesController extends Controller
{
    use AuthorizesRequests;

    /**
     * Store a newly created resource in storage (Like a chirp).
     */
    public function store(Request $request, Chirp $chirp)
    {
        // Create a new like only if user didn't already like it
        if (!$chirp->isLikedBy(auth()->user())) {
            $chirp->likes()->create(['user_id' => auth()->id()]);
        }

        // Return JSON for AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'liked' => true,
                'count' => $chirp->likes()->count()
            ]);
        }

        return back(); // goes back to the pervious page
    }

    /**
     * Remove the specified resource from storage (Unlike a chirp).
     */
    public function destroy(Request $request, Chirp $chirp)
    {
        $chirp->likes()->where('user_id', auth()->id())->delete();

        // Return JSON for AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'liked' => false,
                'count' => $chirp->likes()->count()
            ]);
        }

        return back();
    }
}
