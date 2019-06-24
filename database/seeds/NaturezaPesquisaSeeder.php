<?php

use Illuminate\Database\Seeder;
use PesquisaProjeto\NaturezaPesquisa;

class NaturezaPesquisaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $np1 = new NaturezaPesquisa();
        $np1->descricao = 'Axiomática';
        $np1->save();

        $np2 = new NaturezaPesquisa();
        $np2->descricao = 'Empírica';
        $np2->save();
    }
}
