<?php

use Faker\Generator as Faker;


$factory->define(PesquisaProjeto\Departamento::class, function (Faker $faker) {
    return [
        'descricao' => str_random(10)
    ];
});
