<?php

use Illuminate\Database\Seeder;

class VinculoPesquisaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(PesquisaProjeto\VinculoPesquisa::class,5)->create();
    }
}
