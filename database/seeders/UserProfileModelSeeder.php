<?php

namespace Database\Seeders;

use App\Models\User\UserProfileModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserProfileModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        UserProfileModel::factory()->count(10)->create();
    }
}
