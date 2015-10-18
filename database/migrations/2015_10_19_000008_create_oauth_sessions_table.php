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
 * This is the create oauth sessions table migration class.
 *
 * @author Luca Degasperi <packages@lucadegasperi.com>
 */
class CreateOauthSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_sessions', function (Blueprint $t) {
            $t->increments('id');
            $t->string('client_id', 40);
            $t->enum('owner_type', ['client', 'user'])->default('user');
            $t->string('owner_id');
            $t->string('client_redirect_uri')->nullable();
            $t->timestamps();

            $t->index(['client_id', 'owner_type', 'owner_id']);

            $t->foreign('client_id')
                ->references('id')->on('oauth_clients')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oauth_sessions', function (Blueprint $t) {
            $t->dropForeign('oauth_sessions_client_id_foreign');
        });
        Schema::drop('oauth_sessions');
    }
}
