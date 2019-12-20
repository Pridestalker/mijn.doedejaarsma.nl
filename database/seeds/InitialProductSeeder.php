<?php

use App\User;
use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Database\Seeder;
use App\Notifications\NewProduct;

class InitialProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $doede = User::whereName('Doede Jaarsma')->first();
        $veer = User::whereName('Rob Steijger')->first();

        $product1 = Product::create(
            [
                'name'      => 'Jaarverslag 2019',
                'user_id'   => $doede->id,
                'status'    => 'aangevraagd',
                'soort'     => 'drukwerk',
                'deadline'  => Carbon::tomorrow(),
                'options'   => json_encode([
                    'papier'       => '300mg',
                    'oplage'       => 3000,
                    'afleveradres' => 'Lauriergracht 54 H',
                    'gewicht'      => '300 grams',
                ])
            ]
        );

        Product::create(
            [
                'name'      => 'Jaarverslag 2019 ES',
                'user_id'   => $doede->id,
                'status'    => 'opgepakt',
                'soort'     => 'drukwerk',
                'deadline'  => Carbon::now(),
            ]
        );

        Product::create(
            [
                'name'      => 'Jaarverslag 2019 EN',
                'user_id'   => $veer->id,
                'status'    => 'afgerond',
                'soort'     => 'drukwerk',
                'deadline'  => Carbon::yesterday(),
            ]
        );

        Product::create(
            [
                'name'      => 'Jaarverslag 2019 DK',
                'user_id'   => $veer->id,
                'status'    => 'afgerond',
                'soort'     => 'drukwerk',
                'deadline'  => Carbon::now()->subWeek(2),
            ]
        );

        $users = User::whereIsNot('customer')->get();
        Notification::send($users, new NewProduct($product1));

        $product1->hours()->create([
            'user_id'       => 3,
            'remarks'       => '',
            'hours'         => 1,
            'created_at'    => now()
        ]);
    }
}
