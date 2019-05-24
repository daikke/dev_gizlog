<?php

use Illuminate\Database\Seeder;

class DailyReportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('daily_reports')->truncate();
        DB::table('daily_reports')->insert([
            [
                'user_id'    => 1,
                'title'      =>'一覧機能実装',
                'contents'   =>'インデックスページの編集',
                'reporting_time' => Carbon::create(2019, 1, 15, 9, 50, 22)
            ],
            [
                'user_id'    => 1,
                'title'      =>'新規作成機能実装',
                'contents'   =>'createページの編集',
                'reporting_time' => Carbon::create(2019, 1, 16, 9, 50, 22)
            ],
            [
                'user_id'    => 1,
                'title'      =>'編集機能実装',
                'contents'   =>'editページの編集',
                'reporting_time' => Carbon::create(2019, 1, 17, 9, 50, 22)
            ]
        ]);
    }
}
