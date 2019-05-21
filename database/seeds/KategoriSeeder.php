<?php
use App\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kategori::create(['nama' => 'Kinerja','creator'=>'','modifier'=>'']);
        Kategori::create(['nama' => 'Finansial','creator'=>'','modifier'=>'']);
        Kategori::create(['nama' => 'Keselamatan','creator'=>'','modifier'=>'']);
        Kategori::create(['nama' => 'Operasional','creator'=>'','modifier'=>'']);
        Kategori::create(['nama' => 'Lingkungan','creator'=>'','modifier'=>'']);
        Kategori::create(['nama' => 'Reputasi','creator'=>'','modifier'=>'']);
    }
}
