<?php

use Illuminate\Database\Seeder;

class ProfessorPapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(PesquisaProjeto\ProfessorPapel::class,2)->create();
    }
}
