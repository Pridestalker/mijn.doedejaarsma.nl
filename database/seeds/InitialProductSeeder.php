<?php

use Illuminate\Database\Seeder;

class InitialProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        
        $doede = \App\User::whereName('Doede Jaarsma')->first();
        
        
        \App\Models\Product::create(
            [
                'name'      => 'Jaarverslag 2019',
                'user_id'   => $doede->id,
                'status'    => 'aangevraagd',
                'soort'     => 'drukwerk',
                'deadline'  => \Carbon\Carbon::now(),
                'options'   => json_encode(['papier' => '300mg', 'oplage' => 3000, 'afleveradres' => 'Lauriergracht 54 H', 'gewicht' => '300 grams'])
            ]
        );
        
        \App\Models\Product::create(
            [
                'name'      => 'Jaarverslag 2019 ES',
                'user_id'   => $doede->id,
                'status'    => 'opgepakt',
                'soort'     => 'drukwerk',
                'deadline'  => \Carbon\Carbon::now(),
            ]
        );
        
        \App\Models\Product::create(
            [
                'name'      => 'Jaarverslag 2019 EN',
                'user_id'   => $doede->id,
                'status'    => 'afgerond',
                'soort'     => 'drukwerk',
                'deadline'  => \Carbon\Carbon::now(),
            ]
        );
    }
}
