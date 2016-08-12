<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTraining extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('club_id')->unsigned()->index();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->integer('price');
            $table->enum('priceless', ['N', 'Y'])->default('Y'); //Y - free, N - commercial
            $table->enum('is_active', ['N', 'Y'])->default('Y'); 
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
        Schema::drop('training');
    }
}
