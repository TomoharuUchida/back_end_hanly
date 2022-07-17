<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SignupRequest;


class SignupController extends Controller
{
    public function signup(SignupRequest $request)
    {
        /**
         * @param \App\Http\Requests\Api\SignupRequest $request
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
