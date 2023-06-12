<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsToDurasiSewa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->unsignedBigInteger('durasi_id', 20)->after('id_member');
            $table->foreign('durasi_id')->references('id')->on('durasi_sewa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barangs', function (Blueprint $table) {
            if(Schema::hasColumn('barangs', 'durasi_id')) {
                $table->$table->dropColumn('durasi_id');
            }
        });
    }
}
