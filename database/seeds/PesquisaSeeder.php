<?php

use Illuminate\Database\Seeder;

class PesquisaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(PesquisaProjeto\Pesquisa::class,6)->create();
    }
}
