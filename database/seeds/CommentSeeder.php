<?php

use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comment')->truncate();

        $admin = new \App\Comment();
        $admin->id = "1";
        $admin->author = "1";
        $admin->body = "elso komment";
        $admin->save();

        $admin = new \App\Comment();
        $admin->id = "2";
        $admin->author = "1";
        $admin->body = "masodik komment";
        $admin->save();

        $admin = new \App\Comment();
        $admin->id = "3";
        $admin->author = "2";
        $admin->body = "harmadik komment";
        $admin->save();

        $admin = new \App\Comment();
        $admin->id = "4";
        $admin->author = "1";
        $admin->body = "negyedik komment";
        $admin->save();

        $admin = new \App\Comment();
        $admin->id = "5";
        $admin->author = "3";
        $admin->body = " otodik komment";
        $admin->save();

        $admin = new \App\Comment();
        $admin->id = "6";
        $admin->author = "3";
        $admin->body = "hatodik komment";
        $admin->save();

        $admin = new \App\Comment();
        $admin->id = "7";
        $admin->author = "2";
        $admin->body = "hetedik komment";
        $admin->save();

        $admin = new \App\Comment();
        $admin->id = "8";
        $admin->author = "3";
        $admin->body = "nyolcadik komment";
        $admin->save();

        $admin = new \App\Comment();
        $admin->id = "9";
        $admin->author = "1";
        $admin->body = "kilencedik komment";
        $admin->save();

        $admin = new \App\Comment();
        $admin->id = "10";
        $admin->author = "4";
        $admin->body = "tizedik komment";
        $admin->save();

        $admin = new \App\Comment();
        $admin->id = "11";
        $admin->author = "4";
        $admin->body = "tizendegyedik komment";
        $admin->save();
    }
}
