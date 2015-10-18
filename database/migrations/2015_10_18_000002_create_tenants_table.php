<?php

// use DB;
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
            $t->increments('id');
            // $t->binary('tenant_uuid', 16)->unique();
            $t->string('subdomain', 40)->unique();

            // LARAVE\CASHIER COLUMNS
            $t->tinyInteger('stripe_active')->default(0);
            $t->string('stripe_id')->nullable();
            $t->string('stripe_subscription')->nullable();
            $t->string('stripe_plan', 100)->nullable();
            $t->string('last_four', 4)->nullable();
            $t->timestamp('trial_ends_at')->nullable();
            $t->timestamp('subscription_ends_at')->nullable();

            $t->timestamps();
            $t->softDeletes();
        });

        // add tenant_uuid column as 16 digit binary
        \DB::statement('ALTER TABLE `dev_tenants` ADD `tenant_uuid` BINARY(16) NOT NULL UNIQUE AFTER `id`');
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
