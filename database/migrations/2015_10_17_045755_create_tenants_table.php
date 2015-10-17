<?php

use DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function(Blueprint $t)
        {
            $t->string('id')->primry();
            // $t->binary('tenant_uuid', 16)->unique();
            $t->string('subdomain')->unique();

            $t->timsestamps();
            $t->softDeletes();

        });

        // add tenants_uuid column as 16 digit binary
        DB::statement('ALTER TABLE `tenants` ADD `tenant_uuid` BINARY(16) NOT NULL UNIQUE AFTER `id`');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tenants');
    }
}
