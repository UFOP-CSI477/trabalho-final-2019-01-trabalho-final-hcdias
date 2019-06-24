<?php

use Faker\Generator as Faker;


$factory->define(PesquisaProjeto\ProfessorPapel::class, function (Faker $faker) {
    return [
    	'descricao'=>$faker->text(10)
    ];
});
