<?php

use Illuminate\Database\Seeder;
use PesquisaProjeto\AreaPesquisa;

class AreaPesquisaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $np1 = new AreaPesquisa();
        $np1->descricao = 'Gestão da produção';
        $np1->save();

        $np2 = new AreaPesquisa();
        $np2->descricao = 'Gestão da qualidade';
        $np2->save();

        $np3 = new AreaPesquisa();
        $np3->descricao = 'Gestão econômica';
        $np3->save();

        $np4 = new AreaPesquisa();
        $np4->descricao = 'Ergonomia e segurança do trabalho';
        $np4->save();

        $np5 = new AreaPesquisa();
        $np5->descricao = 'Gestão do produto';
        $np5->save();

        $np6 = new AreaPesquisa();
        $np6->descricao = 'Pesquisa operacional';
        $np6->save();

        $np7 = new AreaPesquisa();
        $np7->descricao = 'Gestão extratégica';
        $np7->save();

        $np8 = new AreaPesquisa();
        $np8->descricao = 'Gestão do conhecimento organizacional';
        $np8->save();

        $np9 = new AreaPesquisa();
        $np9->descricao = 'Gestão ambiental dos processos produtivos';
        $np9->save();

        $np10 = new AreaPesquisa();
        $np10->descricao = 'Educação em engenharia de produção';
        $np10->save();

        $np11 = new AreaPesquisa();
        $np11->descricao = 'Sustentabilidade e responsabilidade social';
        $np11->save();
    }
}