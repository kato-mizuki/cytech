<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //自分でデータを作成する
        Company::create([
            'id' => 1,
            'name' => 'flower',
            'street_address' => '〒105-0011 東京都港区芝公園４丁目２−８',
            'representative' => '加藤',
        ]);

        Company::create([
            'id' => 2,
            'name' => 'tree',
            'street_address' => '〒105-0011 東京都港区芝公園４丁目２−８',
            'representative' => '瑞貴'
        ]);
    }
}
