<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $t) {
            $t->increments('id');
            $t->integer('user_id')->unsigned()->index();
            $t->string('email');
            $t->boolean('is_verified')->default(0);
            $t->boolean('is_primary')->default(0);
            $t->timestamps();
            $t->softDeletes();

            $t->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        // INCREMENT FROM
        DB::statement("ALTER TABLE ".env('DB_PREFIX', 'dev_')."emails AUTO_INCREMENT = 1001");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // drop foreign keys
        Schema::table('emails', function(Blueprint $t)
        {
            $t->dropForeign('emails_user_id_foreign');
        });

        // drop table
        Schema::drop('emails');
    }
}
