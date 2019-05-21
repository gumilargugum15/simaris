<?php
use App\Peluang;
use Illuminate\Database\Seeder;

class PeluangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Peluang::create(['level' => '1','nama' => 'Sangat Kecil','kriteria' => 'Peristiwa kemungkinan terjadi pada beberapa sebagian kecil kondisi <30%','creator'=>'','modifier'=>'']);
        Peluang::create(['level' => '2','nama' => 'Kecil','kriteria' => 'Peristiwa kemungkinan terjadi pada beberapa kondisi (Prosentase > 20%-50%)','creator'=>'','modifier'=>'']);
        Peluang::create(['level' => '3','nama' => 'Sedang','kriteria' => 'Peristiwa kemungkinan terjadi pada sebagian besar kondisi (Prosentase > 50%-70%)','creator'=>'','modifier'=>'']);
        Peluang::create(['level' => '4','nama' => 'Besar','kriteria' => 'Peristiwa kemungkinan terjadi pada hampir semua kondisi (Prosentase > 70%-80%)','creator'=>'','modifier'=>'']);
        Peluang::create(['level' => '5','nama' => 'Sangat Besar','kriteria' => 'Peristiwa kemungkinan terjadi pada semua kondisi (Prosentase > 90%)','creator'=>'','modifier'=>'']);
    }
}
