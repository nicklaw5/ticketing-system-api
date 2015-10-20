<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservedSubdomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserved_subdomains', function(Blueprint $t)
        {
            $t->increments('id');
            $t->string('subdomain', 40);
            
            $t->integer('created_by');
            $t->timestamp('created_at');
            $t->integer('updated_by');
            $t->timestamp('updated_at');
            $t->integer('deleted_by');
            $t->timestamp('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('reserved_subdomains');
    }
}
