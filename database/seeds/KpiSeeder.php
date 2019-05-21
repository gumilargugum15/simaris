<?php
use App\Kpi;
use Illuminate\Database\Seeder;

class KpiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $data = ['kode'=>'A00021','nama'=>'IMPLEMENTASI MBCFPE / KPKU','unit_id'=>'1','tahun'=>'2019','creator'=>'1','modifier'=>''];
        $i = 1;
        while ($i<=10){
            Kpi::create(['kode'=>'A000'.$i,'nama'=>'IMPLEMENTASI MBCFPE / KPKU','unit_id'=>'1','tahun'=>'2019','creator'=>'1','modifier'=>'']);
            $i++;
        }

        
    }
}
