<?php

use Illuminate\Database\Seeder;
use PesquisaProjeto\AgenciaPesquisa;

class AgenciaPesquisaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $np1 = new AgenciaPesquisa();
        $np1->descricao = 'Capes';
        $np1->save();

        $np2 = new AgenciaPesquisa();
        $np2->descricao = 'CNPq';
        $np2->save();

        $np3 = new AgenciaPesquisa();
        $np3->descricao = 'FAPEMIG';
        $np3->save();
    }
}