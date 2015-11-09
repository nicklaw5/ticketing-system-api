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
          // +"full_name": "Nick Law"
          // +"email": "nick@stryve.io"
          // +"phone": "0423 640 190"
          // +"organisation": "Stryve Technologies"          
          // +"ip": "120.149.144.13"
          // +"isoCode": "AU"
          // +"country": "Australia"
          // +"city": "South Yarra"
          // +"state": "VIC"
          // +"postal_code": "3141"
          // +"lat": -37.8333
          // +"lon": 144.9833
          // +"timezone": "Australia/Melbourne"
          // +"continent": "OC"
          // +"default": false

            $t->increments('id');
            $t->string('external_id', 36)->index();             // uuid length
            $t->integer('role_id')->unsigned()->index();
            $t->integer('locale_id')->unsigned()->nullable();
            $t->integer('timezone_id')->unsigned()->nullable();
            $t->string('name');
            $t->string('password', 60);
            $t->boolean('active')->default(1);
            $t->boolean('verified')->default(0);

            
            $t->integer('account_id')->unsigned()->index();                     // must belong to an account
            $t->integer('organization_id')->unsigned()->nullable()->index();    // optional to belong to organization
            $t->integer('branch_id')->unsigned()->nullable()->index();          // optional to belong to branch

            $t->timestamps();
            $t->softDeletes();

            $t->foreign('role_id')->references('id')->on('roles')->onDelete('restrict')->onUpdate('cascade');
            $t->foreign('locale_id')->references('id')->on('locales')->onDelete('restrict')->onUpdate('cascade');
            $t->foreign('timezone_id')->references('id')->on('timezones')->onDelete('restrict')->onUpdate('cascade');
            $t->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade')->onUpdate('cascade');
            $t->foreign('organization_id')->references('id')->on('organizations')->onDelete('set null')->onUpdate('cascade');
            $t->foreign('branch_id')->references('id')->on('branches')->onDelete('set null')->onUpdate('cascade');
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
      // drop foreign keys
        Schema::table('users', function (Blueprint $t) {
            $t->dropForeign('users_role_id_foreign');
            $t->dropForeign('users_locale_id_foreign');
            $t->dropForeign('users_timezone_id_foreign');
            $t->dropForeign('users_account_id_foreign');
            $t->dropForeign('users_organization_id_foreign');
            $t->dropForeign('users_branch_id_foreign');
        });

        // drop table
        Schema::drop('users');
    }
}
