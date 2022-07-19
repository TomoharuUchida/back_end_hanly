<?php

namespace Tests\Feature\Http\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;  // DBを汚したくないならこのトレイトをuse


class SignupTest extends TestCase
{
    // このトレイトはテスト実行中にトランザクション貼ってくれ、
    // テスト後にロールバックしてくれるものです。テスト後もキレイなDBを保ってくれます。
    use DatabaseTransactions;

    /**
     * @test   //← @testアノテーションを書くことで、テスト対象であることを明示します
     */
    // 何をテストするものかを書く。日本語可。英語ならtestXXX()
    public function signupの正常形を確認する()
    {
        // 送信データを定義
        $postData = [
            'email' => 'test@hoge.com',
            'password' => 'password',
            'nickname' => 'nickname',
        ];

        // API実行
        $response = $this->json('POST', route('api.signup.post'), $postData);

        // レスポンスアサート
        $response->assertStatus(201)
            ->assertJson([
                // サーバで振られるIDは確認しようがないので除外
                'email' => $postData['email'],
                'nickname' => $postData['nickname'],
            ]);

        // DBアサート(Friendsテーブルにデータ登録できていることを確認。passwordは暗号化されているので除外)
        $this->assertDatabaseHas('friends', [
            'email' => $postData['email'],
            'nickname' => $postData['nickname']
        ]);
    }

    /**
     * @test
     */
    public function バリデーションテストemailがnullの場合は422エラー()
    {
        $postData = [
            'email' => null,
            'password' => 'password',
            'nickname' => 'nickname'
        ];

        $response = $this->json('POST', route('api.signup.post'), $postData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'email'
            ]);
    }

    /**
     * @test
     */
    public function 異常系_DBへのインサートでエラーになった場合は500エラー()
    {
        // Firendクラスをモックして、store()の挙動を差し替え
        $this->mock(\App\Eloquents\Friend::class, function ($mock) {
            $mock->shouldReceive('store')
                ->once() // １回だけ呼ばれること
                ->withAnyArgs() // 今回はエラーパターンのため、引数は何でもOK（チェックはしない）
                ->andThrow(new \Exception()); // Exceptionをthrowするように変更
        });

        // 送信データを定義
        $postData = [
            'email' => 'test@hoge.com',
            'password' => 'password',
            'nickname' => 'nickname',
        ];

        // API実行
        $response = $this->json('POST', route('api.signup.post'), $postData);

        // アサート
        $response->assertStatus(500);

        // DBアサート（firendsテーブルにデータ登録されていないことを確認）
        $this->assertDatabaseMissing('friends', [
            'email' => $postData['email'],
            'nickname' => $postData['nickname'],
        ]);
    }
}
