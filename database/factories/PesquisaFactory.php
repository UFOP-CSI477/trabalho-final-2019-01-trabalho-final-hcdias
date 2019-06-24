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
use PesquisaProjeto\MinhaUfopUser;

$factory->define(PesquisaProjeto\Pesquisa::class, function (Faker $faker) {

    return [
    	'titulo'=>$faker->text(20),
    	'resumo'=>$faker->text(200),
    	'ano_inicio'=>date('Y'),
    	'semestre_inicio'=>rand(1,2),
    	'status_id'=>PesquisaProjeto\StatusPesquisa::inRandomOrder()->first()->id,
    	'natureza_id'=>PesquisaProjeto\NaturezaPesquisa::inRandomOrder()->first()->id,
    	'abordagem_id'=>PesquisaProjeto\AbordagemPesquisa::inRandomOrder()->first()->id,
    	'objetivo_id'=>PesquisaProjeto\ObjetivoPesquisa::inRandomOrder()->first()->id,
    	'procedimentos_id'=>PesquisaProjeto\ProcedimentosPesquisa::inRandomOrder()->first()->id,
    	'area_id'=>PesquisaProjeto\AreaPesquisa::inRandomOrder()->first()->id,
    	'agencia_id'=>PesquisaProjeto\AgenciaPesquisa::inRandomOrder()->first()->id,
    	'sub_area_id'=>PesquisaProjeto\SubAreaPesquisa::inRandomOrder()->first()->id,
        'orientador_id'=>PesquisaProjeto\MinhaUfopUser::inRandomOrder()->first()->id,
        'coorientador_id'=>PesquisaProjeto\MinhaUfopUser::inRandomOrder()->first()->id
    ];
});
