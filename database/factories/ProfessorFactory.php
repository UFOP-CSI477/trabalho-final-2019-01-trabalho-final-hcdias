<?php

use Faker\Generator as Faker;


$factory->define(PesquisaProjeto\Professor::class, function (Faker $faker) {
    return [
    	'professor_siape'=>$faker->unique()->randomNumber(5),
    	'professor_nome'=>$faker->name,
        'departamento_id'=>rand(1,5)
    ];
});
