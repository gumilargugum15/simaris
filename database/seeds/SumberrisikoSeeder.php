<?php
use App\Sumberrisiko;
use Illuminate\Database\Seeder;

class SumberrisikoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sumberrisiko::create(['risikobisnisdetail_id'=>'1','namasumber'=>'Nama sumber 1','mitigasi'=>'mitigasi 1','biaya'=>'1000','start_date'=>'2019-04-01','end_date'=>'2019-04-07','pic'=>'Afgan','statussumber'=>'ok','creator'=>'','modifier'=>'']);
        Sumberrisiko::create(['risikobisnisdetail_id'=>'1','namasumber'=>'Nama sumber 2','mitigasi'=>'mitigasi 2','biaya'=>'2000','start_date'=>'2019-04-07','end_date'=>'2019-04-10','pic'=>'Beni','statussumber'=>'ok','creator'=>'','modifier'=>'']);
        Sumberrisiko::create(['risikobisnisdetail_id'=>'1','namasumber'=>'Nama sumber 3','mitigasi'=>'mitigasi 3','biaya'=>'3000','start_date'=>'2019-04-10','end_date'=>'2019-04-13','pic'=>'Furqon','statussumber'=>'ok','creator'=>'','modifier'=>'']);
        Sumberrisiko::create(['risikobisnisdetail_id'=>'2','namasumber'=>'Nama sumber 4','mitigasi'=>'mitigasi 4','biaya'=>'4000','start_date'=>'2019-04-13','end_date'=>'2019-04-15','pic'=>'Kurob','statussumber'=>'ok','creator'=>'','modifier'=>'']);
        Sumberrisiko::create(['risikobisnisdetail_id'=>'2','namasumber'=>'Nama sumber 5','mitigasi'=>'mitigasi 5','biaya'=>'5000','start_date'=>'2019-04-15','end_date'=>'2019-04-17','pic'=>'Arga','statussumber'=>'ok','creator'=>'','modifier'=>'']);
        Sumberrisiko::create(['risikobisnisdetail_id'=>'2','namasumber'=>'Nama sumber 6','mitigasi'=>'mitigasi 6','biaya'=>'6000','start_date'=>'2019-04-17','end_date'=>'2019-04-20','pic'=>'Sumi','statussumber'=>'ok','creator'=>'','modifier'=>'']);
        Sumberrisiko::create(['risikobisnisdetail_id'=>'3','namasumber'=>'Nama sumber 7','mitigasi'=>'mitigasi 7','biaya'=>'7000','start_date'=>'2019-04-20','end_date'=>'2019-04-23','pic'=>'Fahru','statussumber'=>'ok','creator'=>'','modifier'=>'']);
        Sumberrisiko::create(['risikobisnisdetail_id'=>'3','namasumber'=>'Nama sumber 8','mitigasi'=>'mitigasi 8','biaya'=>'8000','start_date'=>'2019-04-23','end_date'=>'2019-04-25','pic'=>'Feri','statussumber'=>'ok','creator'=>'','modifier'=>'']);
        Sumberrisiko::create(['risikobisnisdetail_id'=>'3','namasumber'=>'Nama sumber 9','mitigasi'=>'mitigasi 9','biaya'=>'9000','start_date'=>'2019-04-25','end_date'=>'2019-04-27','pic'=>'Rendi','statussumber'=>'ok','creator'=>'','modifier'=>'']);
    }
}
