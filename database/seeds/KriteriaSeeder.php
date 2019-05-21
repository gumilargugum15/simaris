<?php
use App\Kriteria;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kriteria::create(['level' => '5','nama' => 'Kinerja sama sekali tidak tercapai atau pencapaiannya sangat rendah 0% - 20% dari target','dampak_id'=>'5','kategori_id'=>'1','creator'=>'','modifier'=>'']);
        Kriteria::create(['level' => '4','nama' => 'Kinerja hanya tercapai 21% - 40% dari target','dampak_id'=>'4','kategori_id'=>'1','creator'=>'','modifier'=>'']);
        Kriteria::create(['level' => '3','nama' => 'Kinerja hanya tercapai 41% - 85% dari target','dampak_id'=>'3','kategori_id'=>'1','creator'=>'','modifier'=>'']);
        Kriteria::create(['level' => '2','nama' => 'Kinerja hanya tercapai 86% - 95% dari target','dampak_id'=>'2','kategori_id'=>'1','creator'=>'','modifier'=>'']);
        Kriteria::create(['level' => '1','nama' => 'Kinerja hanya tercapai 96% - 99% dari target','dampak_id'=>'1','kategori_id'=>'1','creator'=>'','modifier'=>'']);
    }
}
