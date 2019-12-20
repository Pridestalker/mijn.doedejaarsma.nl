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
        $rob = User::whereName('Rob Steijger')->first();

        $product1 = $this->createAndReturnProductOne($doede);

        $this->createProducts($doede, $rob);

        $users = User::whereIsNot('customer')->get();
        Notification::send($users, new NewProduct($product1));

        $product1->hours()->create([
            'user_id'       => 3,
            'remarks'       => '',
            'hours'         => 1,
            'created_at'    => now()
        ]);
    }

    protected function createAndReturnProductOne(User $user)
    {
        $product = Product::create([
            'name'      => 'Jaarverslag 2019m',
        ]);

        $product->order()->create([
            'user_id'       => $user->id,
            'status'        => 'aangevraagd',
            'deadline'      => Carbon::tomorrow(),
        ]);

        return $product;
    }

    protected function createProducts(User $user, User $user2)
    {
        Product::create([
            'name'      => 'Jaarverslag 2019 ES',
        ])->order()->create([
            'user_id'   => $user->id,
            'status'    => 'opgepakt',
            'deadline'  => Carbon::now()
        ]);

        Product::create([
            'name'      => 'Jaarverslag 2019 EN',
        ])->order()->create([
            'user_id'   => $user2->id,
            'status'    => 'afgerond',
            'deadline'  => Carbon::yesterday()
        ]);

        Product::create([
            'name'      => 'Jaarverslag 2019 DK',
        ])->order()->create([
            'user_id'   => $user2->id,
            'status'    => 'afgerond',
            'deadline'  => Carbon::now()->subWeek(2),
        ]);
    }
}
