<?php

use Illuminate\Database\Seeder;
use \App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //
        $this->createAdmins();
        $this->createDesigners();
        $this->createCustomers();
    }
    
    protected function createAdmins(): void
    {
        $tom = User::create([
            'name'      => 'Tom Govers',
            'username'  => 'tomgovers',
            'email'     => 'tom@doedejaarsma.nl',
            'password'  => Hash::make('Werkplaats54'),
            'created_at'=> \Carbon\Carbon::now(),
            'updated_at'=> \Carbon\Carbon::now(),
        ]);
        
        $mitch = User::create([
            'name'      => 'Mitch Hijlkema',
            'username'  => 'mitchhijlkema',
            'email'     => 'mitch@doedejaarsma.nl',
            'password'  => Hash::make('Werkplaats54'),
            'created_at'=> \Carbon\Carbon::now(),
            'updated_at'=> \Carbon\Carbon::now(),
        ]);
        
        Bouncer::assign('admin')->to($tom);
        Bouncer::assign('admin')->to($mitch);
    }
    
    protected function createDesigners(): void
    {
        $kees = User::create([
            'name'      => 'Kees Jongboom',
            'username'  => 'keesjongboom',
            'email'     => 'kees@doedejaarsma.nl',
            'password'  => Hash::make('Werkplaats54'),
            'created_at'=> \Carbon\Carbon::now(),
            'updated_at'=> \Carbon\Carbon::now(),
        ]);
    
        $lynn = User::create([
            'name'      => 'Lynn van den Berg',
            'username'  => 'lynnvdberg',
            'email'     => 'lynn@doedejaarsma.nl',
            'password'  => Hash::make('Werkplaats54'),
            'created_at'=> \Carbon\Carbon::now(),
            'updated_at'=> \Carbon\Carbon::now(),
        ]);
    
        Bouncer::assign('designer')->to($kees);
        Bouncer::assign('designer')->to($lynn);
    }
    
    protected function createCustomers(): void
    {
        $doede = User::create([
            'name'      => 'Doede Jaarsma',
            'username'  => 'doedejaarsma',
            'email'     => 'dpede@doedejaarsma.nl',
            'password'  => Hash::make('Werkplaats54'),
            'created_at'=> \Carbon\Carbon::now(),
            'updated_at'=> \Carbon\Carbon::now(),
        ]);
        
        Bouncer::assign('customer')->to($doede);
    }
}
