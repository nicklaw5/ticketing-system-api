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
            $t->string('name');
            $t->timestamps();
        });

        // INCREMENT FROM
        DB::statement("ALTER TABLE ".env('DB_PREFIX', 'dev_')."users AUTO_INCREMENT = 1001");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
