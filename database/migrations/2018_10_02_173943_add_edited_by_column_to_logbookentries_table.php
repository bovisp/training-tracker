<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEditedByColumnToLogbookentriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logbookentries', function (Blueprint $table) {
            $table->integer('edited_by')->unsigned()->nullable()->index();

            $table->foreign('edited_by')
                ->references('id')
                ->on('users')
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
        Schema::table('logbookentries', function (Blueprint $table) {
            $table->dropColumn('edited_by');
        });
    }
}
