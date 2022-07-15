<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 環境に応じてダミーデータを出し分ける 以下、Local開発用
        $this->call(LocalDevelopSeeder::class);
    }
}
