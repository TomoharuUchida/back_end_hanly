<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SignupController extends Controller
{
    public function signup(Request $request)
    {
        /**
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\JsonResponse
         */
        $email = $request->input('email');
        $password = $request->input('password');
        $nickname = $request->input('nickname');

        $stored = \App\Eloquents\Friend::create([
            'email' => $email,
            'password' => bcrypt($password),
            'nickname' => $nickname
        ]);

        return response()->json($stored);
    }
}
