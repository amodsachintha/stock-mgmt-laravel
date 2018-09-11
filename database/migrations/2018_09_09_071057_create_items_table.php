<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->float('unit_price');
            $table->integer('low'); //stock level - low
            $table->integer('medium'); //stock level - medium
            $table->unsignedInteger('id_category');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('id_uom');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->engine = "InnoDB";
        });


        Schema::table('items', function ($table) {
            $table->foreign('id_category')->references('id')->on('categories');
            $table->foreign('id_uom')->references('id')->on('uom');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
