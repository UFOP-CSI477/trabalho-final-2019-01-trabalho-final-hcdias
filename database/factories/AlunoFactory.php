<?php

use Faker\Generator as Faker;


$factory->define(PesquisaProjeto\Aluno::class, function (Faker $faker) {
    return [
    	'aluno_matricula'=>$faker->unique()->randomNumber(5),
        'aluno_nome' => $faker->name,
        'curso_id'=>rand(1,5)
    ];
});
