<?php

use Faker\Generator as Faker;
use PesquisaProjeto\AbordagemPesquisa;
use PesquisaProjeto\AgenciaPesquisa;
use PesquisaProjeto\AreaPesquisa;
use PesquisaProjeto\NaturezaPesquisa;
use PesquisaProjeto\ObjetivoPesquisa;
use PesquisaProjeto\ProcedimentosPesquisa;
use PesquisaProjeto\SubAreaPesquisa;
use PesquisaProjeto\StatusPesquisa;

$factory->define(PesquisaProjeto\Pesquisa::class, function (Faker $faker) {

    return [
    	'pesquisa_titulo'=>$faker->text(20),
    	'pesquisa_resumo'=>$faker->text(200),
    	'pesquisa_ano_inicio'=>date('Y'),
    	'pesquisa_semestre_inicio'=>rand(1,2),
    	'status_pesquisa_id'=>PesquisaProjeto\StatusPesquisa::inRandomOrder()->first()->id,
    	'natureza_pesquisa_id'=>PesquisaProjeto\NaturezaPesquisa::inRandomOrder()->first()->id,
    	'abordagem_pesquisa_id'=>PesquisaProjeto\AbordagemPesquisa::inRandomOrder()->first()->id,
    	'objetivo_pesquisa_id'=>PesquisaProjeto\ObjetivoPesquisa::inRandomOrder()->first()->id,
    	'procedimentos_pesquisa_id'=>PesquisaProjeto\ProcedimentosPesquisa::inRandomOrder()->first()->id,
    	'area_pesquisa_id'=>PesquisaProjeto\AreaPesquisa::inRandomOrder()->first()->id,
    	'agencia_pesquisa_id'=>PesquisaProjeto\AgenciaPesquisa::inRandomOrder()->first()->id,
    	'sub_area_pesquisa_id'=>PesquisaProjeto\SubAreaPesquisa::inRandomOrder()->first()->id
    ];
});
