<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersSupervisorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_supervisors', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('supervisor_id')->unsigned();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('supervisor_id')
                ->references('id')
                ->on('supervisors')
                ->onDelete('cascade');

            $table->primary(['user_id', 'supervisor_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_supervisors');
    }
}
