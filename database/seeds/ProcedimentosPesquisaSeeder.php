<?php

use Illuminate\Database\Seeder;
use PesquisaProjeto\ProcedimentosPesquisa;

class ProcedimentosPesquisaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $np1 = new ProcedimentosPesquisa();
        $np1->descricao = 'Estudo de caso';
        $np1->save();

        $np2 = new ProcedimentosPesquisa();
        $np2->descricao = 'Experimento';
        $np2->save();

        $np3 = new ProcedimentosPesquisa();
        $np3->descricao = 'Modelagem e Simulação';
        $np3->save();

        $np4 = new ProcedimentosPesquisa();
        $np4->descricao = 'Pesquisa-ação';
        $np4->save();

        $np5 = new ProcedimentosPesquisa();
        $np5->descricao = 'Soft system methodology';
        $np5->save();

        $np6 = new ProcedimentosPesquisa();
        $np6->descricao = 'Survey';
        $np6->save();
    }
}