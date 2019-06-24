<?php

use Faker\Generator as Faker;


$factory->define(PesquisaProjeto\Curso::class, function (Faker $faker) {
    return [
        'descricao' => str_random(10),
        'departamento_id'=>rand(1,5)
    ];
});
