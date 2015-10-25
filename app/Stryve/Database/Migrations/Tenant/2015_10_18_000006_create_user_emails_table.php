<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_emails', function(Blueprint $t)
        {
            $t->increments('id');
            $t->integer('user_id')->unsigned()->index();
            $t->string('email_address');
            $t->boolean('is_verified')->default(0);
            $t->boolean('is_primary')->default(0);
            $t->integer('updated_by')->unsigned()->nullable();
            $t->nullableTimestamps();
            $t->integer('deleted_by')->unsigned()->nullable();
            $t->softDeletes();

            $t->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('no action');
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
        Schema::drop('user_emails');
    }
}