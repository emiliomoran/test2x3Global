<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');   //Generate uuid in function create
            $table->timestamp('payment_date')->nullable();
            $table->timestamp('expires_at')->useCurrent();
            $table->string('status', 50);
            $table->unsignedBigInteger('user_id');
            $table->float('clp_usd')->nullable();
            $table->foreign('user_id')->references('id')->on('clients');
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
        Schema::dropIfExists('payments');
    }
}
