<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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
            $table->string('reciept_no')->nullable();
            $table->unsignedInteger('id_item');
            $table->unsignedInteger('id_category');
            $table->unsignedInteger('quantity');
            $table->string('purpose')->nullable();
            $table->string('person')->nullable();
            $table->string('approved_by')->nullable();
            $table->timestamp('date_time')->default(DB::raw('CURRENT_TIMESTAMP'));
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
