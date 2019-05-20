<?php

use Faker\Generator as Faker;


$factory->define(PesquisaProjeto\VinculoPesquisa::class, function (Faker $faker) {
    return [
    	'pesquisa_id'=>PesquisaProjeto\Pesquisa::inRandomOrder()->first()->id,
    	'user_id'=>mt_rand(1,3),
    ];
});
