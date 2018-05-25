<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(DepartamentosSeeder::class);
         $this->call(CursoSeeder::class);
         $this->call(AlunoSeeder::class);
         $this->call(ProfessorSeeder::class);
         $this->call(PesquisaSeeder::class);
         $this->call(ProfessorPapelSeeder::class);
         $this->call(VinculoPesquisaSeeder::class);
         $this->call(UserSeeder::class);
    }
}
