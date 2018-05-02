<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuzzlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puzzles', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            
            $table->integer('level');
            $table->integer('solve_time');
            $table->integer('total_solve_time');
            $table->text('pattern_json');
            $table->text('level_json');
            $table->integer('puzzle_resets');
            $table->integer('number_flips');
            $table->integer('total_number_flips');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('puzzles');
    }
}
