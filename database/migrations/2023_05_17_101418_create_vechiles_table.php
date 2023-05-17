<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVechilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vechiles', function (Blueprint $table) {
            $table->id();
            $table->string('model_id')->index();
            $table->string('type')->index();
            $table->integer('year');
            $table->integer('price')->index();
            $table->string('color');
            $table->timestamp('deleted_at')->index();
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
        Schema::dropIfExists('vechiles');
    }
}
