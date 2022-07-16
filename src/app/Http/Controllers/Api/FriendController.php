<?php

namespace App\Http\Controllers\Api;

use App\Eloquents\Friend;
use App\Eloquents\FriendsRelationship;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param int $friendId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, int $friendId)
    {
        // Pinとともに取得
        $friend = Friend::with(['pin'])->find($friendId);

        return response()->json($friend);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        // Tokenから自分のIDを取得
        $myId = $request->user()->id;

        // Eloquentで自分の友だちのIDを取得
        $friendIds = FriendsRelationship::where('own_friends_id', $myId)
            ->get()
            ->pluck('other_friends_id')
            ->toArray();

        // 自分の友だちの情報を取得

        $friends = Friend::with(['pin'])
            ->whereIn('id', $friendIds)
            ->get();

        return response()->json($friends);
    }
}
