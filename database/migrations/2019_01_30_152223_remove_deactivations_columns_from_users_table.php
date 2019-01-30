<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveDeactivationsColumnsFromUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('deactivated_at');
            $table->dropColumn('reactivated_at');
            $table->dropColumn('deactivation_rationale');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('deactivated_at')->nullable();
            $table->date('reactivated_at')->nullable();
            $table->text('deactivation_rationale')->nullable();
        });
    }
}
