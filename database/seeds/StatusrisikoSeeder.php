<?php

use App\Statusrisiko;
use Illuminate\Database\Seeder;

class StatusrisikoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Statusrisiko::create(['nama' => 'Validasi Verifikatur','creator'=>'','modifier'=>'']);
        Statusrisiko::create(['nama' => 'Validasi Atasan','creator'=>'','modifier'=>'']);
        Statusrisiko::create(['nama' => 'Validasi GCG RM','creator'=>'','modifier'=>'']);
        Statusrisiko::create(['nama' => 'Selesai','creator'=>'','modifier'=>'']);
    }
}
