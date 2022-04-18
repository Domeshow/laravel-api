<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //

    public function register(Request $request) {
        $request->validate([
            "name" => "required|max:50",
            "email" => "required|email|max:255",
            "password" => "required|min:6|confirmed",
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);
        
        return $this->registered($request, $user);
    }

    protected function registered(Request $request, $user)
    {
        $user->generateToken();

        return response()->json(['user' => $user], 201);
    }
}
