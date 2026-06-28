<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'name'              => 'John Doe',
                'email'             => 'john@myjobs.loc',
                'password'          => Hash::make('password'),
                'telegram_chat_id'  => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'name'              => 'Jane Doe',
                'email'             => 'jane@myjobs.loc',
                'password'          => Hash::make('password'),
                'telegram_chat_id'  => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ]);
    }
}