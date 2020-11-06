<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sprites', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->string('nombre',10)->nullable();
            $table->string('front',100)->nullable();
            $table->string('back',100)->nullable();
            $table->integer('hp')->default(0);
            $table->integer('atk')->default(0);
            $table->integer('def')->default(0);
            $table->integer('spa')->default(0);
            $table->integer('spd')->default(0);
            $table->integer('spe')->default(0);
            $table->string('tipo_1',20)->nullable();
            $table->string('tipo_2',20)->nullable();
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
        Schema::dropIfExists('sprites');
    }
}
