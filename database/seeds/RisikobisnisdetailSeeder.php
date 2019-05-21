<?php
use App\Risikobisnisdetail;
use Illuminate\Database\Seeder;

class RisikobisnisdetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$data = ['risikobisnis_id'=>'1','kpi_id'=>'1','risiko'=>'Risiko1','akibat'=>'','klasifikasi_id'=>'1','peluang_id'=>'1','dampak_id'=>'1','warna'=>'Hijau','indikator'=>'1','nilaiambang'=>'10'];
        
        Risikobisnisdetail::create(['risikobisnis_id'=>'1','kpi_id'=>'1','risiko'=>'Risiko1','akibat'=>'','klasifikasi_id'=>'1','peluang_id'=>'1','dampak_id'=>'1','warna'=>'Hijau','indikator'=>'1','nilaiambang'=>'10','kaidah'=>'','tglkaidah'=>'','creator'=>'','modifier'=>'']);
        Risikobisnisdetail::create(['risikobisnis_id'=>'1','kpi_id'=>'2','risiko'=>'Risiko2','akibat'=>'','klasifikasi_id'=>'2','peluang_id'=>'2','dampak_id'=>'2','warna'=>'Biru','indikator'=>'2','nilaiambang'=>'20','kaidah'=>'','tglkaidah'=>'','creator'=>'','modifier'=>'']);
        Risikobisnisdetail::create(['risikobisnis_id'=>'1','kpi_id'=>'3','risiko'=>'Risiko3','akibat'=>'','klasifikasi_id'=>'3','peluang_id'=>'3','dampak_id'=>'3','warna'=>'Biru','indikator'=>'3','nilaiambang'=>'30','kaidah'=>'','tglkaidah'=>'','creator'=>'','modifier'=>'']);
    }
}
