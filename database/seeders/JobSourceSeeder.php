<?php

namespace Database\Seeders;

use App\Models\JobSource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JobSource::insertOrIgnore([
            [
                'name'       => 'DOU',
                'slug'       => 'dou',
                'base_url'   => 'https://dou.ua',
                'is_active'  => true,
                'config'     => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Djinni',
                'slug'       => 'djinni',
                'base_url'   => 'https://djinni.co',
                'is_active'  => true,
                'config'     => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Remotive',
                'slug'       => 'remotive',
                'base_url'   => 'https://remotive.com/api/remote-jobs',
                'is_active'  => true,
                'config'     => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
