<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $t)
        {
            $t->increments('id');
            $t->integer('organisation_id')->unsigned()->index()->nullable();
            $t->integer('user_type_id')->unsigned();
            $t->boolean('is_tenant_owner')->default(0);
            $t->boolean('is_primary_contact')->default(0);
            $t->string('first_name');
            $t->string('last_name')->nullable();
            
            $t->string('ip', 15)->nullable();
            $t->string('isoCode', 2)->nullable();
            $t->string('city')->nullable();
            $t->string('state')->nullable();
            $t->string('post_code')->nullable();
            $t->string('country')->nullable();
            $t->string('timezone')->default('UTC');
            $t->string('continent', 2)->nullable();

            $t->integer('created_by')->unsigned()->nullable();
            $t->integer('updated_by')->unsigned()->nullable();
            $t->nullableTimestamps();
            $t->integer('deleted_by')->unsigned()->nullable();
            $t->softDeletes();

            $t->foreign('organisation_id')->references('id')->on('organisations')->onDelete('no action')->onUpdate('no action');
            $t->foreign('user_type_id')->references('id')->on('user_types')->onDelete('restrict')->onUpdate('no action');
            $t->foreign('created_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $t->foreign('updated_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            $t->foreign('deleted_by')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $t)
        {
            $t->dropForeign('users_organisation_id_foreign');
            $t->dropForeign('users_user_type_id_foreign');
            $t->dropForeign('users_updated_by_foreign');
            $t->dropForeign('users_deleted_by_foreign');
        });

        Schema::drop('users');
    }
}
