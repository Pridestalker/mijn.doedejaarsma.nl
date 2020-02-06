<?php
/**
 * @var $factory
 */

use App\User;
use Carbon\Carbon;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(
    Product::class,
    function (Faker $faker) {
        return [
            //
            'name'          => $faker->unique()->name,
            'description'   => $faker->optional()->paragraph,
            'format'        => $faker->optional()->text,
            'factuur'       => $faker->optional(0.5)->text,
            'kostenplaats'  => $faker->optional(0.2)->city,
            'referentie'    => $faker->optional(0.3)->text,

            'user_id'       => function () {
                return factory(User::class)->create()->id;
            },

            'soort'         => 'digitaal',
            'status'        => 'aangevraagd',
            'deadline'      => Carbon::tomorrow()->toDateString(),
        ];
    }
);

$factory->state(Product::class, 'drukwerk', [
    'soort'     => 'drukwerk'
]);
