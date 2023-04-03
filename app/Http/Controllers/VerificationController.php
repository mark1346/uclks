<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = User::find($request->route('id'));
        if ($user->hasVerifiedEmail()) {
            return response()->json(["email-already-verified"], 200);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
        return response()->json(["email-verified"], 200);
    }
}
