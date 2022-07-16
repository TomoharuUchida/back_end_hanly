<?php

namespace App\Http\Controllers\Api;

use App\Eloquents\Friend;
use App\Eloquents\FriendsRelationship;
use App\Eloquents\Pin;
use App\Http\Controllers\Controller;
use Facades\App\Contracts\Distance;
use Illuminate\Http\Request;

class PinController extends Controller
{
    public function store(Request $request)
    {
        /**
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\JsonResponse
         */
        $newFriends = \DB::transaction(function () use ($request) {
            // アクセスしてきた人のiDを取得
            $myFriendId = $request->user()->id;

            // 自分のPinを削除
            Pin::where('friends_id', $myFriendId)->delete();

            // 改めて自分のPinを登録
            $myPin = new Pin;
            $myPin->fill([
                'friends_id' => $myFriendId,
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
            ]);
            $myPin->save();

            // 既に友だちの人を取得
            $myFriends = FriendsRelationship::where('own_friends_id', $myFriendId)->get();

            // まだ友だちではない人を取得
            $notFriends = Friend::with(['pin'])
                ->where('id', '<>', $myFriendId) //自分以外
                ->whereNotIn('id', $myFriends->pluck('other_friends_id')->toArray()) //既に友だちの人を除外,配列を渡して除外
                ->whereHas('pin', function ($query) {
                    //hasの問い合わせにwhereで条件を付す whereHasでpin(リレーション？)を持っている人だけ
                    // かつ追加クエリで、5分前より後にPinを打った人のみ
                    $query->where('created_at', '>=', now()->subMinutes(5));
                })
                ->get();

            // 近くのピンの人（友だちになれそうな人）を探す
            // 実装は別途作成済みのものを使う
            $canBeFriendIds = Distance::canBeFriends($myPin->toArray(), $notFriends->pluck('pin')->toArray());

            // 近くのピンの人がいれば友だちになる
            foreach ($canBeFriendIds as $othersId) {
                // 自分の友だちとして登録
                $myRelation = new FriendsRelationship;
                $myRelation->fill([
                    'own_friends_id' => $myFriendId,
                    'other_friends_id' => $othersId
                ]);
                $myRelation->save();
                // 相手の友だちとして自分を登録
                $myRelation = new FriendsRelationship;
                $myRelation->fill([
                    'own_friends_id' => $othersId,
                    'other_friends_id' => $myFriendId
                ]);
                $myRelation->save();
            }

            // 新しく友だちになった人を返す
            return Friend::with(['pin'])
                ->whereIn('id', $canBeFriendIds)
                ->get();
        });

        return response()->json($newFriends);
    }
}
