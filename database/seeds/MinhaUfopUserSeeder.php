<?php

use Illuminate\Database\Seeder;
use PesquisaProjeto\MinhaUfopUser;
use PesquisaProjeto\Group;

class MinhaUfopUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = Group::where('descricao','admin')->first();
        $role_user = Group::where('descricao','DEENP')->first();
        $role_aluno = Group::where('descricao','Sistemas de Informação')->first();
        //$role_coordenador = Role::where('name','coordenador')->first();


        $user1 = new MinhaUfopUser();
        $user1->name = "professor1";
        $user1->email = "professor1@ufop.br";
        $user1->cpf = 1;
        $user1->group_id = $role_user->id;
        $user1->extra_group_id = $role_admin->id;
        $user1->save();

        $user2 = new MinhaUfopUser();
        $user2->name = "professor2";
        $user2->email = "professor2@ufop.br";
        $user2->cpf = 12;
        $user2->group_id = $role_user->id;
        $user2->save();


        $user3 = new MinhaUfopUser();
        $user3->name = "professor3";
        $user3->email = "professor3@ufop.br";
        $user3->cpf = 1237;
        $user3->group_id = $role_user->id;;
        $user3->save();


        $user4 = new MinhaUfopUser();
        $user4->name = "professor4";
        $user4->email = "professor4@ufop.com";
        $user4->cpf = 12343;
        $user4->group_id = $role_user->id;;
        $user4->save();


        $user44 = new MinhaUfopUser();
        $user44->name = "professor5";
        $user44->email = "xixariy@key-mail.net";
        $user44->cpf = 12345678910;
        $user44->group_id = $role_user->id;;
        $user44->save();
   

        $user5 = new MinhaUfopUser();
        $user5->name = "aluno";
        $user5->email = "aluno@ufop.com";
        $user5->cpf = 123;
        $user5->group_id = $role_aluno->id;
        $user5->save();


        $user6 = new MinhaUfopUser();
        $user6->name = "aluno2";
        $user6->email = "aluno2@ufop.com";
        $user6->cpf = 1234567891;
        $user6->group_id = $role_aluno->id;;
        $user6->save();


        $user7 = new MinhaUfopUser();
        $user7->name = "aluno1";
        $user7->email = "aluno1@ufop.com";
        $user7->cpf = 12345678912;
        $user7->group_id = $role_aluno->id;;
        $user7->save();


    }
}
