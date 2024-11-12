<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserStatsController extends Controller
{
    public function index(Request $request)
    {
        // $user = auth()->user();
        $user = $request->user();

        return response()->json([
            'publications' => $user->publications()->count(),
            'books' => $user->books()->count(),
            'courses' => $user->courses()->count(),
        ]);
    }
}
