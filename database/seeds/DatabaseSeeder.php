<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         
         $this->call(DampakSeeder::class);
         $this->call(KlasifikasiSeeder::class);
         $this->call(KpiSeeder::class);
         $this->call(PeluangSeeder::class);
         $this->call(PeriodeRisikoBisnisSeeder::class);
         $this->call(RisikobisnisdetailSeeder::class);
         $this->call(RisikobisnisSeeder::class);
         $this->call(RolesAndPermissionsSeeder::class);
         $this->call(StatusrisikoSeeder::class);
         $this->call(SumberrisikoSeeder::class);
         $this->call(UsersTableSeeder::class);
         $this->call(UnitSeeder::class);
    }
}
