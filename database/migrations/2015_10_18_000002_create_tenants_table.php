<?php

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
            // tenant_uuid'
            $t->string('subdomain', 40)->unique();  // use this for db_name also
            $t->string('db_name', 40)->unique();    // replace dashsed in subdomain with underscores
            $t->string('db_connection', 20);

            // OWNER COLUMNS
            $t->string('owner_company_nane');
            $t->string('owner_first_name');
            $t->string('owner_last_name')->nullable();
            $t->string('owner_email');
            $t->string('owner_phone', 16)->nullable();
            $t->string('owner_ip', 15);

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

        $db_prefix = Config::get('database.connections.'.env('DB_CONNECTION_0', 'dev_').'.prefix');

        // add tenant_uuid column as 16 digit binary
        DB::statement("ALTER TABLE `".$db_prefix."tenants` ADD `uuid` BINARY(16) NOT NULL UNIQUE AFTER `id`");
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
