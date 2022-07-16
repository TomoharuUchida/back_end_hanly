<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class EloquentTest extends TestCase
{
    /**
     * @test
     */


    // public function IDを指定して１件取得()
    // {
    //     $friend = \App\Eloquents\Friend::find(1);

    //     // dd($friend);

    //     $this->assertTrue(true);
    // }


    // public function 全件取得()
    // {
    //     $friends = \App\Eloquents\Friend::all();

    //     // dd($friend);
    //     dd($friends);

    //     $this->assertTrue(true);
    // }

    // public function 条件指定取得（ニックネームにuchidaを含む）()
    // {
    //     $friend = \App\Eloquents\Friend::where('nickname', 'like', '%uchida%')->get();

    //     dd($friend);

    //     $this->assertTrue(true);
    // }

    // public function Friendに1件データを登録()
    // {
    //     $newFriend = \App\Eloquents\Friend::create(
    //         [
    //             'nickname' => 'うーちーだー',
    //             'email' => 'hogehoge@test.com',
    //             'password' => bcrypt('password-desu'),
    //             'image_path' => null,
    //             'remember_token' => \Str::random(80),
    //         ]
    //     );

    //     dd($newFriend);

    //     $this->assertTrue(true);
    // }

    // public function FriendのデータをID指定で1件更新()
    // {
    //     $updated = \App\Eloquents\Friend::find(1)
    //         ->fill(
    //             [
    //                 'nickname' => 'uchidauchida',
    //             ]
    //         )
    //         ->save();
    //     // true or falseが返る
    //     dd($updated);

    //     $this->assertTrue(true);
    // }

    public function FriendのデータをID指定で削除()
    {
        $delete = \App\Eloquents\Friend::destroy(2);

        // 削除した件数が返る
        dd($delete);

        $this->assertTrue(true);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
}
