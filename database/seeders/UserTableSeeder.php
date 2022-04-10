<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = 
        [
            [
                'name' => "山田太郎",
                'email' => "test@test.com",
                // 'email_verified_at' => "test@test.com",
                'password' => Hash::make('password'),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
