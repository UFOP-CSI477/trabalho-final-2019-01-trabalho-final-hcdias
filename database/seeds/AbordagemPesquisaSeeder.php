<?php

use Illuminate\Database\Seeder;
use PesquisaProjeto\AbordagemPesquisa;

class AbordagemPesquisaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $np1 = new AbordagemPesquisa();
        $np1->descricao = 'Qualitativa';
        $np1->save();

        $np2 = new AbordagemPesquisa();
        $np2->descricao = 'Quantitativa';
        $np2->save();

        $np3 = new AbordagemPesquisa();
        $np3->descricao = 'Combinada';
        $np3->save();
    }
}
