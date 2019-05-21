<?php
use App\Klasifikasi;
use Illuminate\Database\Seeder;

class KlasifikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Klasifikasi::create(['nama' => 'Strategis','creator'=>'','modifier'=>'']);
        Klasifikasi::create(['nama' => 'Operasional','creator'=>'','modifier'=>'']);
        Klasifikasi::create(['nama' => 'Keuangan','creator'=>'','modifier'=>'']);
        Klasifikasi::create(['nama' => 'Kepatuhan','creator'=>'','modifier'=>'']);
        
    }
}
