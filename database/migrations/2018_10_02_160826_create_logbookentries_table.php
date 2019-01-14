<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogbookentriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logbookentries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('logbook_id')->unsigned()->index();
            $table->longText('body');
            $table->timestamp('edited_at')->nullable();
            $table->timestamps();

            $table->foreign('logbook_id')
                ->references('id')
                ->on('logbooks')
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
        Schema::dropIfExists('logbookentries');
    }
}
