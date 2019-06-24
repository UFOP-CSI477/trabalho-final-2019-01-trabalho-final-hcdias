<?php

use Faker\Generator as Faker;


$factory->define(PesquisaProjeto\Aluno::class, function (Faker $faker) {
    return [
    	'matricula'=>$faker->unique()->randomNumber(5),
        'nome' => $faker->name,
        'curso_id'=>rand(1,5)
    ];
});
