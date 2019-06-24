<?php

use Illuminate\Database\Seeder;
use PesquisaProjeto\Group;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $np0 = new Group();
        $np0->codigo = 1;
        $np0->descricao = 'admin';
        $np0->roles_id = 3;
        $np0->save();

        $np00 = new Group();
        $np00->codigo = 2;
        $np00->descricao = 'coordenador';
        $np00->roles_id = 4;
        $np00->save();        

        $np1 = new Group();
        $np1->codigo = 714;
        $np1->descricao = 'ICEA';
        $np1->roles_id = 1;
        $np1->save();

        $np2 = new Group();
        $np2->codigo = 716;
        $np2->descricao = 'DEENP';
        $np2->roles_id = 1;
        $np2->save();

        $np3 = new Group();
        $np3->codigo = 715;
        $np3->descricao = 'DECEA';
        $np3->roles_id = 1;
        $np3->save();

        $np4 = new Group();
        $np4->codigo = 71481;
        $np4->descricao = 'DEELT';
        $np4->roles_id = 1;
        $np4->save();

        $np5 = new Group();
        $np5->codigo = 71130;
        $np5->descricao = 'DECSI';
        $np5->roles_id = 1;
        $np5->save();

        $np6 = new Group();
        $np6->codigo = 7215;
        $np6->descricao = 'Engenharia de Produção';
        $np6->roles_id = 2;
        $np6->save();        

        $np7 = new Group();
        $np7->codigo = 7213;
        $np7->descricao = 'Engenharia de Computação';
        $np7->roles_id = 2;
        $np7->save();        

        $np8 = new Group();
        $np8->codigo = 7217;
        $np8->descricao = 'Engenharia Elétrica';
        $np8->roles_id = 2;
        $np8->save();        

        $np9 = new Group();
        $np9->codigo = 7236;
        $np9->descricao = 'Sistemas de Informação';
        $np9->roles_id = 2;
        $np9->save();        

    }
}
