<?php

use Illuminate\Database\Seeder;
use PesquisaProjeto\User;
use PesquisaProjeto\Group;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(PesquisaProjeto\User::class)->create();
        $role_admin = Group::where('descricao','admin')->first();
        $role_user = Group::where('descricao','DEENP')->first();
        $role_aluno = Group::where('descricao','Sistemas de Informação')->first();
        $role_coordenador = Group::where('descricao','coordenador')->first();

        $user = new User();
        $user->name = "professor";
        $user->email = "professor@ufop.com";
        $user->password = password_hash('ufop',PASSWORD_DEFAULT);
        $user->group_id = $role_user->id;
        $user->save();


        $user = new User();
        $user->name = "aluno";
        $user->email = "aluno@ufop.com";
        $user->password = password_hash('ufop',PASSWORD_DEFAULT);
        $user->group_id = $role_aluno->id;
        $user->save();


        $admin = new User();
        $admin->name = "admin";
        $admin->email = "admin@admin.com";
        $admin->password = password_hash('admin',PASSWORD_DEFAULT);
        $admin->group_id = $role_admin->id;
        $admin->save();

        $coordenador = new User();
        $coordenador->name = "coordenador";
        $coordenador->email = "coordenador@ufop.com";
        $coordenador->password = password_hash('ufop',PASSWORD_DEFAULT);
        $coordenador->group_id = $role_coordenador->id;
        $coordenador->save();
    }
}
