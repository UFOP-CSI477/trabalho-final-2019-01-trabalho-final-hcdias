<?php

use Illuminate\Database\Seeder;
use PesquisaProjeto\ObjetivoPesquisa;

class ObjetivoPesquisaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $np1 = new ObjetivoPesquisa();
        $np1->descricao = 'Descritivo';
        $np1->save();

        $np2 = new ObjetivoPesquisa();
        $np2->descricao = 'Explicativo';
        $np2->save();

        $np3 = new ObjetivoPesquisa();
        $np3->descricao = 'Exploratório';
        $np3->save();

        $np4 = new ObjetivoPesquisa();
        $np4->descricao = 'Normativo';
        $np4->save();
    }
}