<?php

use Illuminate\Database\Seeder;
use PesquisaProjeto\User;
use PesquisaProjeto\Role;

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
        $role_admin = Role::where('name','admin')->first();
        $role_user = Role::where('name','professor')->first();
        $role_aluno = Role::where('name','aluno')->first();

        $user = new User();
        $user->name = "professor";
        $user->email = "professor@ufop.com";
        $user->password = password_hash('ufop',PASSWORD_DEFAULT);
        $user->save();
        $user->roles()->attach($role_user);


        $user = new User();
        $user->name = "aluno";
        $user->email = "aluno@ufop.com";
        $user->password = password_hash('ufop',PASSWORD_DEFAULT);
        $user->save();
        $user->roles()->attach($role_aluno);

        $admin = new User();
        $admin->name = "admin";
        $admin->email = "admin@admin.com";
        $admin->password = password_hash('admin',PASSWORD_DEFAULT);
        $admin->save();
        $admin->roles()->attach($role_admin);
        $admin->roles()->attach($role_user);
        $admin->roles()->attach($role_aluno);
    }
}
