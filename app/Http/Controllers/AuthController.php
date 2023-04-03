<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users,email",
            "password" => ["required", "regex:/[a-z]/", "regex:/[A-Z]/", 'regex:/[0-9]/', 'regex:/[!()-.?[\]_`~;:@#$%^&*+=]/'],
            "confirmation" => "required|same:password",
        ]);
        $user = User::create([
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);
        $profile = Profile::create([
            'user_id' => $user->id,
            'name' => $fields['name'],
        ]);

        event(new Registered($user));

        return response()->json(["message" => "User Successfuly Created"], 200);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            "email" => "required|string",
            "password" => "required|string",
        ]);

        if (!auth()->attempt($fields)) {
            return response()->json(["errors" => "login-fail"], 401);
        }
        return response()->json(["message" => "Login Success"], 200);
    }

    public function getUserInfo(Request $request)
    {
        return $request->user();
    }

    public function getUserProfile(Request $request)
    {
        return $request->user()->profile;
    }

    public function updateProfile(Request $request)
    {
        $fields = $request->validate([
            "name" => "required|string",
            "birthday" => "date|nullable",
            "gender" => "required|digits_between:0,2",
            "degree" => "required|digits_between:0,3",
            "department" => "string|nullable",
        ]);

        $profile = auth()->user()->profile;

        $profile->name = $fields["name"];
        $profile->birthday = $fields["birthday"];
        $profile->gender = $fields["gender"];
        $profile->degree = $fields["degree"];
        $profile->department = $fields["department"];
        $profile->save();

        return response()->json(["changed" => $profile->wasChanged()], 200);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        return response()->json(["message" => "Logout Success"], 200);
    }

    public function changePassword(Request $request)
    {
        $fields = $request->validate([
            "current-password" => "required|string",
            "new-password" => ["required", "regex:/[a-z]/", "regex:/[A-Z]/", 'regex:/[0-9]/', 'regex:/[!()-.?[\]_`~;:@#$%^&*+=]/'],
            "confirmation" => "required|same:new-password",
        ]);

        if (!(Hash::check($fields['current-password'], auth()->user()->password))) {
            return response()->json(["errors" => "current-password-not-match"], 401);
        }

        if ($fields['current-password'] === $fields['new-password']) {
            return response()->json(["errors" => "same-password"], 401);
        }

        $user = auth()->user();
        $user->password = bcrypt($fields['new-password']);
        $user->save();

        return response()->json(["message" => "password-changed"], 200);
    }

    public function changeEmail(Request $request)
    {
        $fields = $request->validate([
            "email" => "required|email",
        ]);

        $user = auth()->user();
        $user->email = $fields['email'];
        $user->email_verified_at = null;
        $user->save();

        $user->sendEmailVerificationNotification();
        return response()->json(["email-send"], 200);
    }
}
