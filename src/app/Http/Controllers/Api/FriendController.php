<?php

namespace App\Http\Controllers\Api;

use App\Eloquents\Friend;
use App\Eloquents\FriendsRelationship;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FriendShowRequest;
use Illuminate\Http\Request;


class FriendController extends Controller
{
    /**
     * @param \App\Http\Requests\Api\FriendShowRequest $request
     * @param int $friendId
     * @return \App\Http\Resources\FriendResource
     */
    public function show(FriendShowRequest $request, int $friendId)
    {
        // Pinとともに取得
        $friend = Friend::with(['pin'])->find($friendId);

        return new \App\Http\Resources\FriendResource($friend);
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\FriendCollection
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

        return new  \App\Http\Resources\FriendCollection($friends);
    }
}
