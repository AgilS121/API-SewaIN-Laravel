<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kategori');
            $table->unsignedBigInteger('id_subkategori');
            $table->unsignedBigInteger('id_member');
            $table->string('nama_barang');
            $table->text('deskripsi');
            $table->string('image');
            $table->string('harga');
            $table->string('stok');
            $table->timestamps();

            $table->foreign('id_kategori')->references('id')->on('kategories');
            $table->foreign('id_subkategori')->references('id')->on('subkategories');
            $table->foreign('id_member')->references('id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangs');
    }
}
