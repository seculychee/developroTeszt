<?php

use Illuminate\Database\Seeder;

class BasicErrorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('basic_error')->truncate();

        $admin = new \App\BasicError();
        $admin->code = "401";
        $admin->message = "Auth error";
        $admin->save();

        $admin = new \App\BasicError();
        $admin->code = "403";
        $admin->message = "Permission error";
        $admin->save();

        $admin = new \App\BasicError();
        $admin->code = "404";
        $admin->message = "Post or Comment not found";
        $admin->save();

        $admin = new \App\BasicError();
        $admin->code = "422";
        $admin->message = "Validation failed";
        $admin->save();


    }
}
