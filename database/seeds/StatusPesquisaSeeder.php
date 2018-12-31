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
            'em fase de concepção',
            'em fase de desenvolvimento',
            'em fase de de geração de resultados',
            'em fase de publicação',
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
