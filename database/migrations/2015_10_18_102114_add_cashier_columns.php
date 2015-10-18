<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCashierColumns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tenants', function(Blueprint $t)
		{
			$t->tinyInteger('stripe_active')->default(0);
			$t->string('stripe_id')->nullable();
			$t->string('stripe_subscription')->nullable();
			$t->string('stripe_plan', 100)->nullable();
			$t->string('last_four', 4)->nullable();
			$t->timestamp('trial_ends_at')->nullable();
			$t->timestamp('subscription_ends_at')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tenants', function(Blueprint $t)
		{
			$t->dropColumn(
				'stripe_active',
				'stripe_id',
				'stripe_subscription',
				'stripe_plan',
				'last_four',
				'trial_ends_at',
				'subscription_ends_at'
			);
		});
	}

}
