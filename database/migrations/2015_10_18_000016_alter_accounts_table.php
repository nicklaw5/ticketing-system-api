<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function(Blueprint $t)
        {
            $t->foreign('owner_id')->references('id')
                                  ->on('users')
                                  ->onUpdate('cascade')
                                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // drop foreign keys
        Schema::table('accounts', function (Blueprint $t) {
         $t->dropForeign('accounts_owner_id_foreign');
        });
    }
}
