<?php

namespace Database\Seeders;

use App\Models\UserPreference;
use Illuminate\Database\Seeder;

class UserPreferenceSeeder extends Seeder
{
    public function run(): void
    {
        UserPreference::insert([
            [
                'user_id'    => 1,
                'keywords'   => json_encode(['PHP', 'Laravel']),
                'locations'  => json_encode(['remote']),
                'categories' => json_encode(['Software Development']),
                'salary_min' => 50000,
                'salary_max' => 150000,
                'remote_only'=> true,
                'frequency'  => 'daily',
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id'    => 2,
                'keywords'   => json_encode(['Laravel', 'JavaScript']),
                'locations'  => null,
                'categories' => json_encode(['Software Development']),
                'salary_min' => null,
                'salary_max' => null,
                'remote_only'=> true,
                'frequency'  => 'weekly',
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}