<?php

use Illuminate\Database\Seeder;
use PesquisaProjeto\StatusPesquisa;

class StatusPesquisaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $arr = [
            'Em fase de concepção',
            'Em fase de desenvolvimento',
            'Em fase de de geração de resultados',
            'Em fase de publicação',
            'Publicado',
            'Cancelado'
        ];

        foreach($arr as $item){
            $sp = new StatusPesquisa();
            $sp->descricao = $item;
            $sp->save();
        }

    }
}
