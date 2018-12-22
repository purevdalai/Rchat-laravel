<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = new \App\Role;
        $permission->name = 'Админ';
        $permission->code = 'ADMIN';
        $permission->save();

        $permission = new \App\Role;
        $permission->name = 'Ажилтан';
        $permission->code = 'EMPLOYEE';
        $permission->save();
    }
}
