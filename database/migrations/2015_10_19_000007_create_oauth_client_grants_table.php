<?php

/*
 * This file is part of OAuth 2.0 Laravel.
 *
 * (c) Luca Degasperi <packages@lucadegasperi.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * This is the create oauth client grants table migration class.
 *
 * @author Luca Degasperi <packages@lucadegasperi.com>
 */
class CreateOauthClientGrantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_client_grants', function (Blueprint $t) {
            $t->increments('id');
            $t->string('client_id', 40);
            $t->string('grant_id', 40);
            $t->timestamps();

            $t->index('client_id');
            $t->index('grant_id');

            $t->foreign('client_id')
                  ->references('id')->on('oauth_clients')
                  ->onDelete('cascade')
                  ->onUpdate('no action');

            $t->foreign('grant_id')
                  ->references('id')->on('oauth_grants')
                  ->onDelete('cascade')
                  ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oauth_client_grants', function (Blueprint $t) {
            $t->dropForeign('oauth_client_grants_client_id_foreign');
            $t->dropForeign('oauth_client_grants_grant_id_foreign');
        });
        Schema::drop('oauth_client_grants');
    }
}
