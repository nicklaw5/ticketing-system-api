<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $t) {
            $t->increments('id');
            $t->string('external_id', 36)->index();             // uuid length
            $t->integer('account_id')->unsigned()->index();
            $t->string('name');
            
            // Dates
            $t->timestamps();
            $t->softDeletes();

            // Foreign Keys
            $t->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::table('organizations', function (Blueprint $t) {
            $t->dropForeign('organizations_account_id_foreign');
        });

        // drop table
        Schema::drop('organizations');
    }
}
