<?php

use BichoEnsaboado\Models\Role;
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
        $developer = new Role();
        $developer->name         = 'developer';
        $developer->display_name = 'Desenvolvedor'; 
        $developer->description  = 'User is the developer of project';
        $developer->save();

        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'Administrador';
        $admin->description  = 'User is allowed to manage and edit other users'; 
        $admin->save();
       
        $employee = new Role();
        $employee->name         = 'employee';
        $employee->display_name = 'Funcionário';
        $employee->description  = 'User employee of pet'; 
        $employee->save();
    }
}
