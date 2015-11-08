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
          // +"subdomain": "stryve-tech-123"
          // +"database": "stryve_tech_123"
          // +"database_prefix": "o8j_"
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
            $t->string('name');
            $t->string('email');
            $t->string('password', 60);

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
