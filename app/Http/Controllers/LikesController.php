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
        if (!$chirp->isLikedBy(auth()->user())) {
            $chirp->likes()->create(['user_id' => auth()->id()]);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage (Unlike a chirp).
     */
    public function destroy(Request $request, Chirp $chirp)
    {
        $chirp->likes()->where('user_id', auth()->id())->delete();

        return back();
    }
}
