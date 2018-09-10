<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLedgerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledger',function (Blueprint $table){
            $table->mediumIncrements('id');
            $table->boolean('in');
            $table->unsignedInteger('id_item');
            $table->unsignedInteger('id_category');
            $table->unsignedInteger('quantity');
            $table->string('purpose')->nullable();
            $table->string('for')->nullable();
            $table->timestamp('date_time')->nullable();
            $table->timestamps();

            $table->engine = "InnoDB";
        });

        Schema::table('ledger',function ($table){
            $table->foreign('id_item')->references('id')->on('items');
            $table->foreign('id_category')->references('id')->on('categories');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ledger');
    }
}
