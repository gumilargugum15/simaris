<?php
use App\Unitkerja;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unitkerja::create(['kode' => '33403','nama' => 'Urusan Preparation A&I DR Plant','kodecc'=>'1','namacc'=>'A','creator'=>'','modifier'=>'']);
    }
}
