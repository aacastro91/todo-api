<?php

use App\Main\Todo\Todo;
use Faker\Generator as Faker;

$factory->define(Todo::class, function (Faker $faker) {
    return [
        "tarefa" => $faker->words(3, true),
        "concluido" => $faker->boolean()
    ];
});
