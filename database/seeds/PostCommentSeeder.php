<?php

use Illuminate\Database\Seeder;

class PostCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comment_post')->truncate();

        $admin = new \App\CommentPost();
        $admin->post_id = "1";
        $admin->comment_id = "2";
        $admin->save();

        $admin = new \App\CommentPost();
        $admin->post_id = "1";
        $admin->comment_id = "3";
        $admin->save();

        $admin = new \App\CommentPost();
        $admin->post_id = "1";
        $admin->comment_id = "4";
        $admin->save();

        $admin = new \App\CommentPost();
        $admin->post_id = "2";
        $admin->comment_id = "3";
        $admin->save();

        $admin = new \App\CommentPost();
        $admin->post_id = "2";
        $admin->comment_id = "5";
        $admin->save();

        $admin = new \App\CommentPost();
        $admin->post_id = "2";
        $admin->comment_id = "6";
        $admin->save();

        $admin = new \App\CommentPost();
        $admin->post_id = "3";
        $admin->comment_id = "7";
        $admin->save();

        $admin = new \App\CommentPost();
        $admin->post_id = "4";
        $admin->comment_id = "9";
        $admin->save();

        $admin = new \App\CommentPost();
        $admin->post_id = "4";
        $admin->comment_id = "10";
        $admin->save();

        $admin = new \App\CommentPost();
        $admin->post_id = "4";
        $admin->comment_id = "11";
        $admin->save();


    }
}
