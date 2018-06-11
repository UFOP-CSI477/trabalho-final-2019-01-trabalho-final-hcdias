<?php

use Illuminate\Database\Seeder;
use PesquisaProjeto\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = new PesquisaProjeto\Role();
        $role_user->name = "professor";
        $role_user->description = "Normal user,basic permissions";
        $role_user->save();

        $role_aluno = new PesquisaProjeto\Role();
        $role_aluno->name = "aluno";
        $role_aluno->description = "Normal user,basic permissions";
        $role_aluno->save();

        $role_admin = new PesquisaProjeto\Role();
        $role_admin->name = "admin";
        $role_admin->description = "Admin user,all permissions";
        $role_admin->save();
    }
}
