<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call('BasicErrorSeeder');
        $this->call('UserSeeder');
        $this->call('CommentSeeder');
        $this->call('PostSeeder');
        $this->call('PostCommentSeeder');
    }
}
