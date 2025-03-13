<?php

namespace Database\Seeders;

use App\Models\CookingInstruction\CookingStepModel;
use Illuminate\Database\Seeder;

class CookingStepSeeder extends Seeder
{
    public function run()
    {
        CookingStepModel::factory()->count(20)->create();
    }
}
