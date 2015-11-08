<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $t) {
            
            $t->increments('id');
            $t->integer('owner_id')->nullable()->unsigned();
            $t->string('subdomain', 40)->unique();
            $t->string('url');
            $t->string('name');
            $t->boolean('is_sandbox');
            $t->string('timezone');

            // LARAVE\CASHIER COLUMNS
            $t->tinyInteger('stripe_active')->default(0);
            $t->string('stripe_id')->nullable();
            $t->string('stripe_subscription')->nullable();
            $t->string('stripe_plan', 100)->nullable();
            $t->string('last_four', 4)->nullable();
            $t->timestamp('trial_ends_at')->nullable();
            $t->timestamp('subscription_ends_at')->nullable();

            // DATES
            $t->timestamps();
            $t->softDeletes();

            // FOREIGN KEYS
            $t->foreign('owner_id')->references('id')
                                  ->on('users')
                                  ->onUpdate('cascade')
                                  ->onDelete('set null');

        });

        // INCREMENT FROM
        DB::statement("ALTER TABLE ".env('DB_PREFIX', 'dev_')."accounts AUTO_INCREMENT = 1001");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	// drop foreign keys
    	Schema::table('accounts', function (Blueprint $t) {
    		$t->dropForeign('accounts_owner_id_foreign');
    	});

    	// drop table
        Schema::drop('accounts');
    }
}
