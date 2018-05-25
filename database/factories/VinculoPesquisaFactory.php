<?php

use Faker\Generator as Faker;


$factory->define(PesquisaProjeto\VinculoPesquisa::class, function (Faker $faker) {
    return [
    	'pesquisa_id'=>mt_rand(1,5),
    	'professor_papel_id'=>mt_rand(1,2),
    	'aluno_id'=>mt_rand(1,10),
    	'professor_id'=>mt_rand(1,5)
    ];
});
