<?php
use App\Risikobisnis;
use Illuminate\Database\Seeder;

class RisikobisnisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['periode'=>'Kwartal I','tahun'=>'2019','unit_id'=>'1','statusrisiko_id'=>'1','creator'=>'1','modifier'=>''];
        Risikobisnis::create($data);
    }
}
