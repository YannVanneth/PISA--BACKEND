<?php

namespace Database\Seeders;

use App\Models\CookingInstruction;
use Illuminate\Database\Seeder;

class CookingInstructionSeeder extends Seeder
{
    public function run()
    {
        CookingInstruction\CookingInstructionModel::factory()->count(10)->create();
    }
}
