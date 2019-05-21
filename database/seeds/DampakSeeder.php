<?php
use App\Dampak;
use Illuminate\Database\Seeder;

class DampakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dampak::create(['level' => '1','nama' => 'Tidak Signifikan','creator'=>'','modifier'=>'']);
        Dampak::create(['level' => '2','nama' => 'Tidak terlalu merugikan','creator'=>'','modifier'=>'']);
        Dampak::create(['level' => '3','nama' => 'Merugikan','creator'=>'','modifier'=>'']);
        Dampak::create(['level' => '4','nama' => 'Sangat merugikan','creator'=>'','modifier'=>'']);
        Dampak::create(['level' => '5','nama' => 'Bencana','creator'=>'','modifier'=>'']);
    }
}
