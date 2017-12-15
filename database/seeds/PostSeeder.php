<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post')->truncate();

        $admin = new \App\Post();
        $admin->id = "1";
        $admin->slug = "elso slug";
        $admin->author = "1";
        $admin->title = "elso post title";
        $admin->body = "elso post body ";
        $admin->comments = "1";
        $admin->save();

        $admin = new \App\Post();
        $admin->id = "2";
        $admin->slug = "masodik slug";
        $admin->author = "2";
        $admin->title = "madosik post title";
        $admin->body = "madosik post";
        $admin->comments = "2";
        $admin->save();

        $admin = new \App\Post();
        $admin->id = "3";
        $admin->slug = "harmadik slug";
        $admin->author = "2";
        $admin->title = "harmadik post title";
        $admin->body = "harmadik post body";
        $admin->comments = "3";
        $admin->save();

        $admin = new \App\Post();
        $admin->id = "4";
        $admin->slug = "negyedik slug";
        $admin->author = "1";
        $admin->title = "negyedik post title";
        $admin->body = "negyedik post body";
        $admin->comments = "4";
        $admin->save();
    }
}
