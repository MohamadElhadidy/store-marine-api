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
        Schema::create('externals', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->bigInteger('equipment')->unsigned()->index();
            $table->string('workshop');
            $table->string('repairs');
            $table->string('price');
            $table->Integer('employee')->index();
            $table->Integer('supervisor')->index();
            $table->Integer('entry')->index();
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
        Schema::dropIfExists('externals');
    }
};
