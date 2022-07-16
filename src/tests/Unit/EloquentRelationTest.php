<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class EloquentRelationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */

    // public function リレーションすごい()
    // {
    //     $friend = \App\Eloquents\Friend::find(1);

    //     // 1対多を取得しているのでCollectionオブジェクトが返る
    //     $relationship = $friend->relationship;

    //     $myFriendIds = [];
    //     foreach ($relationship as $myFriend) {
    //         $myFriendIds[] = $myFriend->other_friends_id;
    //     }

    //     dd($myFriendIds);

    //     $this->assertTrue(true);
    // }

    // public function Friend経由でPinの座標を取得()
    // {
    //     $pin = \App\Eloquents\Friend::find(1)->pin;
    //     dd($pin->toArray());
    //     $this->assertTrue(true);
    // }

    // public function Pin経由でFriendのニックネームを取得()
    // {
    //     $friend = \App\Eloquents\Pin::where('friends_id', 1)->first()->friends;
    //     dd($friend->nickname);
    //     $this->assertTrue(true);
    // }

    // 単一カラムの値をコレクションで取得したい場合はpluckメソッドを使う

    // public function Pin経由でFriendRelationshipの友だちを取得()
    // {
    //     $friend = \App\Eloquents\Pin::where('friends_id', 1)
    //         ->first()
    //         ->friends;

    //     $otherFriendIds = $friend->relationship->pluck('other_friends_id');
    //     dd($otherFriendIds);
    //     $this->assertTrue(true);
    // }

    // whereInメソッドは、指定した配列の中にカラムの値が含まれている条件を加える
    // public function さらにそこから友だちの名前を取得()
    // {
    //     $friend = \App\Eloquents\Pin::where('friends_id', 1)
    //         ->first()
    //         ->friends;

    //     $otherFriendIds = $friend->relationship->pluck('other_friends_id');

    //     $otherFriends = \App\Eloquents\Friend::whereIn('id', $otherFriendIds)->get();

    //     dd($otherFriends->pluck('nickname'));
    //     $this->assertTrue(true);
    // }

    // hasメソッド 関連づけたモデルのレコードに基づいて、モデルのレコードに対するマッチングを絞り込みたい場合
    public function Pinを持っているFriendだけを取得()
    {
        $friends = \App\Eloquents\Friend::whereHas('pin')->get();

        dd($friends->toArray());
        $this->assertTrue(true);
    }
}
