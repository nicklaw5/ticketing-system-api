<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $t) {
            $t->increments('id');
            $t->string('external_id', 36)->index();             // uuid length
            $t->integer('organization_id')->unsigned()->index();
            $t->string('name');
            $t->timestamps();
            $t->softDeletes();

            $t->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::table('branches', function (Blueprint $t) {
            $t->dropForeign('branches_organization_id_foreign');
        });

        // drop table
        Schema::drop('branches');
    }
}
