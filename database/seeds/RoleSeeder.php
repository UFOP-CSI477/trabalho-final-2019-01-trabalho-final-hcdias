<?php

use Illuminate\Database\Seeder;
use PesquisaProjeto\Role;
use PesquisaProjeto\Group;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $group_admin = Group::where('codigo',1)->first();
        $group_coordenador = Group::where('codigo',2)->first();
        $group_professor = Group::whereIn('codigo',[714,715,716,71481,71130])->get();
        $group_aluno = Group::whereIn('codigo',[7215,7213,7217,7236])->get();
        

        $role_professor = new PesquisaProjeto\Role();
        $role_professor->name = "professor";
        $role_professor->description = "Normal user,basic permissions";
        $role_professor->save();
        //$role_professor->groups()->attach($group_professor);

        $role_aluno = new PesquisaProjeto\Role();
        $role_aluno->name = "aluno";
        $role_aluno->description = "Normal user,basic permissions";
        $role_aluno->save();
        //$role_aluno->groups()->attach($group_aluno);

        $role_admin = new PesquisaProjeto\Role();
        $role_admin->name = "admin";
        $role_admin->description = "Admin user,all permissions";
        $role_admin->save();
       // $role_admin->groups()->attach($group_admin);

        $role_coordenador = new PesquisaProjeto\Role();
        $role_coordenador->name = "coordenador";
        $role_coordenador->description = "Coodenador user,read permissions";
        $role_coordenador->save();
        //$role_coordenador->groups()->attach($group_coordenador);
    }
}
