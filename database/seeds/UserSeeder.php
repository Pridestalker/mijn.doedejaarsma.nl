<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

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
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $mitch = User::create([
            'name'      => 'Mitch Hijlkema',
            'username'  => 'mitchhijlkema',
            'email'     => 'mitch@doedejaarsma.nl',
            'password'  => Hash::make('Werkplaats54'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
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
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $lynn = User::create([
            'name'      => 'Lynn van den Berg',
            'username'  => 'lynnvdberg',
            'email'     => 'lynn@doedejaarsma.nl',
            'password'  => Hash::make('Werkplaats54'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Bouncer::assign('designer')->to($kees);
        Bouncer::assign('designer')->to($lynn);
    }

    protected function createCustomers(): void
    {
        $doede = User::create([
            'name'      => 'Doede Jaarsma',
            'username'  => 'doedejaarsma',
            'email'     => 'doede@doedejaarsma.nl',
            'password'  => Hash::make('Werkplaats54'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $rob = User::create([
            'name'      => 'Rob Steijger',
            'username'  => 'robsteijger',
            'email'     => 'rob@casadelvino.nl',
            'password'  => Hash::make('Werkplaats54'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Bouncer::assign('customer')->to($doede);
        Bouncer::assign('customer')->to($rob);

        DB::table('team_user')->insert(
            [
                'team_id'   => 2,
                'user_id'   => $doede->id,
            ]
        );
        DB::table('team_user')->insert(
            [
                'team_id'   => 2,
                'user_id'   => $rob->id,
            ]
        );
    }
}
