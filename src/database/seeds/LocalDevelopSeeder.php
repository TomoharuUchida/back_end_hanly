<?php

use Illuminate\Database\Seeder;

class LocalDevelopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Factoryの定義に合わせて、１０件のデータをつくってくれー
        // factory(\App\Eloquents\Friend::class, 10)->create();

        // 友だちを1名作成
        factory(\App\Eloquents\Friend::class, 1)
            ->create([
                'nickname' => 'uchida',
                'email' => 'uchida@test.com'
            ])
            ->each(function ($friend) {
                // 友だち関係を作る
                factory(\App\Eloquents\FriendsRelationship::class, 3)->create([
                    'own_friends_id' => $friend->id,
                ]);

                // Pinデータも作っておく
                factory(\App\Eloquents\Pin::class)->create([
                    'friends_id' => $friend->id,
                ]);
            });

        // 友だちのいないユーザーを作成
        factory(\App\Eloquents\Friend::class, 1)->create([
            'nickname' => 'alone',
            'email' => 'alone@test.com'
        ])
            ->each(function ($friend) {
                // Pinデータを作っておく
                factory(\App\Eloquents\Pin::class)->create([
                    'friends_id' => $friend->id,
                ]);
            });

        // あとは適当なユーザーを3人作成
        factory(\App\Eloquents\Friend::class, 3)
            ->create()
            ->each(function ($friend) {
                factory(\App\Eloquents\FriendsRelationship::class, 3)->create([
                    'own_friends_id' => $friend->id,
                ]);

                factory(\App\Eloquents\Pin::class)->create([
                    'friends_id' => $friend->id,
                ]);
            });

        \Artisan::call('passport:client --password');
    }
}
