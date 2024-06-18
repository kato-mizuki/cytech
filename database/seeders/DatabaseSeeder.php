<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('companies')->insert([
            'id' => 4,
            'company_name' => 'flower',
            'street_address' => '〒105-0011 東京都港区芝公園４丁目２−８',
            'representative' => '加藤',

            'id' => 7,
            'company_name' => 'rose',
            'street_address' => '東京都港区芝公園４丁目２−８',
            'representative' => '瑞貴'
        ]);
    }
}
