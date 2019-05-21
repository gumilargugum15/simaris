<?php
use App\Perioderisikobisnis;
use Illuminate\Database\Seeder;

class PeriodeRisikoBisnisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Perioderisikobisnis::create(['nama' => 'Kwartal I 2019','start_date' => '2019-01-01','end_date' => '2019-03-31','aktif'=>1,'creator'=>'admin','modifier'=>'']);
        Perioderisikobisnis::create(['nama' => 'Kwartal II 2019','start_date' => '2019-04-01','end_date' => '2019-06-30','aktif'=>0,'creator'=>'admin','modifier'=>'']);
    }
}
