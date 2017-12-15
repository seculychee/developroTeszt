<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        $admin = new \App\User();
        $admin->id = "1";
        $admin->name = "Elso Szemely";
        $admin->email = "elso@elso.hu";
        $admin->save();

        $admin = new \App\User();
        $admin->id = "2";
        $admin->name = "Masodik Szemely";
        $admin->email = "masodik@masodik.hu";
        $admin->save();

        $admin = new \App\User();
        $admin->id = "3";
        $admin->name = "Harmadik Szemely";
        $admin->email = "harmadik@harmadik.hu";
        $admin->save();

        $admin = new \App\User();
        $admin->id = "4";
        $admin->name = "Negyedik Szemely";
        $admin->email = "negyedik@negyedik.hu";
        $admin->save();

    }
}
