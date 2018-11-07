<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logbooks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userlesson_id');
            $table->integer('objective_id');
            $table->timestamps();

            $table->foreign('userlesson_id')
                ->references('id')
                ->on('userlessons')
                ->onDelete('cascade');

            $table->foreign('objective_id')
                ->references('id')
                ->on('objectives')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logbooks');
    }
}
