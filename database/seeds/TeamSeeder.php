<?php

use Illuminate\Database\Seeder;
use \App\Models\Team;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Team::create(
            [
                'name'  => '113 Zelfmoordpreventie',
                'email' => 'support+113@doedejaarsma.nl'
            ]
        );
        
        Team::create(
            [
                'name'  => 'Orthocenter',
                'email' => 'support+orthocenter@doedejaarsma.nl'
            ]
        );
    }
}
