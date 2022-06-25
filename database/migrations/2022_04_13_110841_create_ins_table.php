<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ins', function (Blueprint $table) {
            $table->id();
            $table->integer('order_num');
            $table->date('date');
            $table->bigInteger('supplier')->unsigned()->index();
            $table->Integer('entry')->index();
            $table->bigInteger('item')->unsigned()->index();
            $table->string('balance');
            $table->string('price');
            $table->string('notes')->nullable();
            $table->bigInteger('store')->unsigned()->index();
            $table->integer('is_delete')->default('0');
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
        Schema::dropIfExists('ins');
    }
};
