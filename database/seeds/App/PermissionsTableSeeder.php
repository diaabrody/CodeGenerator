<?php

use Illuminate\Database\Seeder;

use App\Permission;


class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $createPost = new Permission();
        $createPost->name         = 'create-code';
        $createPost->display_name = 'Create code';

        $createPost->description  = 'create new code';
        $createPost->save();

        $editUser = new Permission();
        $editUser->name         = 'edit-code';
        $editUser->display_name = 'Edit Code';
        $editUser->save();

        $delete = new Permission();
        $delete->name         = 'delete-code';
        $delete->display_name = 'Delete Code';
        $delete->save();

        $view= new Permission();
        $view->name         = 'view-code';
        $view->display_name = 'View Code';
        $view->save();
    }
}
