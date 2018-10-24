<?php

use Faker\Generator as Faker;


$factory->define(PesquisaProjeto\Professor::class, function (Faker $faker) {
    return [
    	'siape'=>$faker->unique()->randomNumber(5),
    	'nome'=>$faker->name,
        'departamento_id'=>rand(1,5)
    ];
});
