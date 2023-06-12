<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDurasiSewaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('durasi_sewa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_durasi');
            $table->timestamps();
        });

        $durasiSewaData = [
            ['nama_durasi' => '1 Hari'],
            ['nama_durasi' => '2 Hari'],
            ['nama_durasi' => '3 Hari'],
            ['nama_durasi' => '4 Hari'],
            ['nama_durasi' => '5 Hari'],
            ['nama_durasi' => '6 Hari'],
            ['nama_durasi' => '8 Hari'],
            ['nama_durasi' => '9 Hari'],
            ['nama_durasi' => '10 Hari'],
            ['nama_durasi' => '11 Hari'],
            ['nama_durasi' => '12 Hari'],
            ['nama_durasi' => '13 Hari'],
            ['nama_durasi' => '15 Hari'],
            ['nama_durasi' => '16 Hari'],
            ['nama_durasi' => '17 Hari'],
            ['nama_durasi' => '18 Hari'],
            ['nama_durasi' => '19 Hari'],
            ['nama_durasi' => '20 Hari'],
            ['nama_durasi' => '22 Hari'],
            ['nama_durasi' => '23 Hari'],
            ['nama_durasi' => '24 Hari'],
            ['nama_durasi' => '25 Hari'],
            ['nama_durasi' => '26 Hari'],
            ['nama_durasi' => '27 Hari'],
            ['nama_durasi' => '29 Hari'],
            ['nama_durasi' => '30 Hari'],
            ['nama_durasi' => '1 Jam'],
            ['nama_durasi' => '2 Jam'],
            ['nama_durasi' => '3 Jam'],
            ['nama_durasi' => '4 Jam'],
            ['nama_durasi' => '5 Jam'],
            ['nama_durasi' => '6 Jam'],
            ['nama_durasi' => '7 Jam'],
            ['nama_durasi' => '8 Jam'],
            ['nama_durasi' => '9 Jam'],
            ['nama_durasi' => '10 Jam'],
            ['nama_durasi' => '11 Jam'],
            ['nama_durasi' => '12 Jam'],
            ['nama_durasi' => '13 Jam'],
            ['nama_durasi' => '14 Jam'],
            ['nama_durasi' => '15 Jam'],
            ['nama_durasi' => '16 Jam'],
            ['nama_durasi' => '17 Jam'],
            ['nama_durasi' => '18 Jam'],
            ['nama_durasi' => '19 Jam'],
            ['nama_durasi' => '20 Jam'],
            ['nama_durasi' => '21 Jam'],
            ['nama_durasi' => '22 Jam'],
            ['nama_durasi' => '23 Jam'],
            ['nama_durasi' => '1 Minggu'],
            ['nama_durasi' => '2 Minggu'],
            ['nama_durasi' => '4 Minggu'],
        ];

        DB::table('durasi_sewa')->insert($durasiSewaData);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('durasi_sewa');
    }
}

