<?php

namespace App\Http\Controllers\Api;

use App\Eloquents\Friend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function me(Request $request)
    {
        /**
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\JsonResponse
         */
        // Tokenから自分のIDを取得
        // $request->user()は、認証済みユーザーのインスタンスを返す
        $myId = $request->user()->id;

        $myInfo = Friend::with(['pin'])->find($myId);

        return response()->json($myInfo);
    }
}
