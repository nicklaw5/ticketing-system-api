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
 * This is the create oauth session scopes table migration class.
 *
 * @author Luca Degasperi <packages@lucadegasperi.com>
 */
class CreateOauthSessionScopesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_session_scopes', function (Blueprint $t) {
            $t->increments('id');
            $t->integer('session_id')->unsigned();
            $t->string('scope_id', 40);

            $t->timestamps();

            $t->index('session_id');
            $t->index('scope_id');

            $t->foreign('session_id')
                  ->references('id')->on('oauth_sessions')
                  ->onDelete('cascade');

            $t->foreign('scope_id')
                  ->references('id')->on('oauth_scopes')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oauth_session_scopes', function (Blueprint $t) {
            $t->dropForeign('oauth_session_scopes_session_id_foreign');
            $t->dropForeign('oauth_session_scopes_scope_id_foreign');
        });
        Schema::drop('oauth_session_scopes');
    }
}
