<?php

use Illuminate\Database\Seeder;
use PesquisaProjeto\StatusTccProposta;

class StatusTccPropostaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $arr = [
            'Aguardando aprovação do professor',
            'Aprovado pelo professor',
            'Rejeitado pelo professor',
            'Aguardando aprovação do colegiado',
            'Aprovado pelo colegiado',
            'Reprovado pelo colegiado'
        ];

        foreach($arr as $item){
            $sp = new StatusTccProposta();
            $sp->descricao = $item;
            $sp->save();
        }
    }
}
