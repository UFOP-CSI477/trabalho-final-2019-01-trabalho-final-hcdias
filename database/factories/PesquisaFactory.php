<?php

use Faker\Generator as Faker;


$factory->define(PesquisaProjeto\Pesquisa::class, function (Faker $faker) {
    return [
    	'pesquisa_titulo'=>$faker->text(20),
    	'pesquisa_resumo'=>$faker->text(200),
    	'pesquisa_ano_inicio'=>date('Y'),
    	'pesquisa_semestre_inicio'=>rand(1,2),
    	'pesquisa_status'=>rand(1,6),
    	'natureza_pesquisa_id'=>rand(1,2),
    	'abordagem_pesquisa_id'=>rand(1,3),
    	'objetivo_pesquisa_id'=>rand(1,4),
    	'procedimentos_pesquisa_id'=>rand(1,6),
    	'area_pesquisa_id'=>rand(1,11),
    	'agencia_pesquisa_id'=>rand(1,3),
    	'sub_area_pesquisa_id'=>rand(1,58)
    ];
});
