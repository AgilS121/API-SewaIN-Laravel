<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMidtransTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('midtrans_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_sewa');
            $table->string('status');
            $table->text('payment_type');
            $table->date('transaction_time');
            $table->string('amount');
            $table->string('transaction_id');
            $table->string('va_number');
            $table->string('bank');
            $table->timestamps();

            $table->foreign('id_sewa')->references('id')->on('sewas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('midtrans_transactions');
    }
}
