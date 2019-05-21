<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimarisTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risikobisnis', function (Blueprint $table) {
            $table->increments ('id');
            $table->string ('periode');
            $table->string ('tahun');
            $table->unsignedInteger ('unit_id');
            $table->unsignedInteger ('statusrisiko_id');
            $table->string ('creator');
            $table->string ('modifier');
            $table->timestamps();
        });

        Schema::create('risikobisnisdetail', function (Blueprint $table) {
            $table->increments ('id');
            $table->unsignedInteger ('risikobisnis_id');
            $table->string ('kpi_id');
            $table->string ('risiko');
            $table->string ('akibat');
            $table->unsignedInteger ('klasifikasi_id');
            $table->unsignedInteger ('peluang_id');
            $table->unsignedInteger ('dampak_id');
            $table->string ('warna');
            $table->string ('indikator');
            $table->string ('nilaiambang');
            $table->string ('kaidah');
            $table->string ('tglkaidah');
            $table->string ('creator');
            $table->string ('modifier');
            $table->timestamps();
        });

        Schema::create('sumberrisiko', function (Blueprint $table) {
            $table->increments ('id');
            $table->unsignedInteger ('risikobisnisdetail_id');
            $table->string ('namasumber');
            $table->string ('mitigasi');
            $table->string ('biaya');
            $table->string ('start_date');
            $table->string ('end_date');
            $table->string ('pic');
            $table->string ('statussumber');
            $table->string ('creator');
            $table->string ('modifier');
            $table->timestamps();
        });

        Schema::create('validasibisnis', function (Blueprint $table) {
            $table->increments ('id');
            $table->unsignedInteger ('risikobisnis_id');
            $table->string ('nik');
            $table->string ('nama');
            $table->string ('jabatan');
            $table->unsignedInteger ('aktorvalidasi_id');
            $table->unsignedInteger ('statusvalidasi_id');
            $table->string ('tglvalidasi');
            $table->timestamps();
        });

        Schema::create('aktorvalidasi', function (Blueprint $table) {
            $table->increments ('id');
            $table->string ('nama');
            $table->timestamps();
        });

        Schema::create('kpi', function (Blueprint $table) {
            $table->increments ('id');
            $table->string ('kode');
            $table->string ('nama');
            $table->unsignedInteger ('unit_id');
            $table->string ('tahun');
            $table->string ('creator');
            $table->string ('modifier');
            $table->timestamps();
        });

        Schema::create('klasifikasi', function (Blueprint $table) {
            $table->increments ('id');
            $table->string ('nama');
            $table->string ('creator');
            $table->string ('modifier');
            $table->timestamps();
        });

        Schema::create('statusvalidasi', function (Blueprint $table) {
            $table->increments ('id');
            $table->string ('nama');
            $table->string ('creator');
            $table->string ('modifier');
            $table->timestamps();
        });

        Schema::create('peluang', function (Blueprint $table) {
            $table->increments ('id');
            $table->string ('level');
            $table->string ('nama');
            $table->string ('kriteria');
            $table->string ('creator');
            $table->string ('modifier');
            $table->timestamps();
        });

        Schema::create('unitkerja', function (Blueprint $table) {
            $table->increments ('id');
            $table->string ('kode');
            $table->string ('nama');
            $table->string ('kodecc');
            $table->string ('namacc');
            $table->string ('creator');
            $table->string ('modifier');
            $table->timestamps();
        });

        Schema::create('perioderisikobisnis', function (Blueprint $table) {
            $table->increments ('id');
            $table->string ('nama');
            $table->date ('start_date');
            $table->date ('end_date');
            $table->integer ('aktif');
            $table->string ('creator');
            $table->string ('modifier');
            $table->timestamps();
        });

        Schema::create('dampak', function (Blueprint $table) {
            $table->increments ('id');
            $table->string ('level');
            $table->string ('nama');
            $table->string ('creator');
            $table->string ('modifier');
            $table->timestamps();
        });

        Schema::create('kriteria', function (Blueprint $table) {
            $table->increments ('id');
            $table->string ('level');
            $table->string ('nama');
            $table->unsignedInteger ('dampak_id');
            $table->unsignedInteger ('kategori_id');
            $table->string ('creator');
            $table->string ('modifier');
            $table->timestamps();
        });

        Schema::create('kategori', function (Blueprint $table) {
            $table->increments ('id');
            $table->string ('nama');
            $table->string ('creator');
            $table->string ('modifier');
            $table->timestamps();
        });

        Schema::create('statusrisiko', function (Blueprint $table) {
            $table->increments ('id');
            $table->string ('nama');
            $table->string ('creator');
            $table->string ('modifier');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
