<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_phones', function(Blueprint $t)
        {
            $t->increments('id');
            $t->integer('user_id')->unsigned()->index();
            $t->string('phone', 30);
            $t->boolean('is_primary')->default(0);
            $t->integer('updated_by')->unsigned();
            $t->timestamps();
            $t->integer('deleted_by')->unsigned();
            $t->softDeletes();

            $t->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $t->foreign('updated_by')->references('id')->on('users')->onDelete('no action');
            $t->foreign('deleted_by')->references('id')->on('users')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_phones', function(Blueprint $t)
        {
            $t->dropForeign('user_phones_user_id_foreign');
            $t->dropForeign('user_phones_updated_by_foreign');
            $t->dropForeign('user_phones_deleted_by_foreign');
        });

        Schema::drop('user_phones');
    }
}