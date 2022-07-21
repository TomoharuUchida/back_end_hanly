<?php

namespace Tests\Feature\Http\Api;

use App\Eloquents\Friend;
use App\Eloquents\Pin;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MeTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    // ImageControllerの@showが設定できていないので保留
    // public function meの正常系を確認する()
    // {

    //     // 準備 送信データを定義
    //     $friend = factory(Friend::class)->create([
    //         'nickname' => 'some data',
    //         'email' => 'testaddress@hoge.com',
    //         'image_path' => '/test/hoge/fuga.jpg'
    //     ]);
    //     $pin = factory(Pin::class)->create([
    //         'friends_id' => $friend->id,
    //     ]);

    //     // 実行
    //     $response = $this->actingAs($friend, 'api')
    //         ->json('GET', route('api.me.get'));

    //     // アサート
    //     $response->assertStatus(200)
    //         ->assertJson([
    //             'id' => $friend->id,
    //             'nickname' => $friend->nickname,
    //             'email' => $friend->email,
    //             'image_url' => route('web.image.get', [
    //                 'friendId' => $friend->id,
    //                 't' => $friend->updated_at->getTimestamp()
    //             ]),
    //             'pin' => [
    //                 'datetime' => $pin->created_at->toIso8601String(),
    //                 'latitude' => $pin->latitude,
    //                 'longitude' => $pin->longitude,
    //             ],
    //         ]);
    // }

    /**
     * @test
     */
    public function meの正常系を確認_image_pathがnullの場合()
    {

        // 準備 送信データを定義
        $friend = factory(Friend::class)->create([
            'image_path' => null,
        ]);
        $pin = factory(Pin::class)->create([
            'friends_id' => $friend->id,
        ]);

        // 実行
        $response = $this->actingAs($friend, 'api')
            ->json('GET', route('api.me.get'));

        // アサート
        $response->assertStatus(200)
            ->assertJson([
                'id' => $friend->id,
                'nickname' => $friend->nickname,
                'email' => $friend->email,
                'image_url' => null,
                'pin' => [
                    'datetime' => $pin->created_at->toIso8601String(),
                    'latitude' => $pin->latitude,
                    'longitude' => $pin->longitude,
                ],
            ]);
    }

    /**
     * @test
     */
    public function 異常系_DBへのアクセスでエラーになった場合は500エラー()
    {
        // Firendクラスをモック
        $this->mock(\App\Eloquents\Friend::class, function ($mock) {
            $mock->shouldReceive('findById')
                ->once()
                ->withAnyArgs()
                ->andThrow(new \Exception());
        });

        $friend = factory(Friend::class)->create();

        $response = $this->actingAs($friend, 'api')
            ->json('GET', route('api.me.get'));

        $response->assertStatus(500);
    }
}
