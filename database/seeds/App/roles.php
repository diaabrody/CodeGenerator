<?php

use Illuminate\Database\Seeder;
use App\Role;


class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $owner = new Role();
        $owner->name         = 'sales-agent';
        $owner->display_name = 'sales agent';
        $owner->save();

        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'User Administrator';
        $admin->description  = 'User is allowed to manage and edit other proposals and users';
        $admin->save();
    }
}
