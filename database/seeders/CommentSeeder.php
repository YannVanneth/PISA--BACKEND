<?php

namespace Database\Seeders;

use App\Models\User\UserCommentModel;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder{
    public function run(){
        UserCommentModel::factory()->count(10)->create();
    }
}
