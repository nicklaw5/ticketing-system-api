<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OauthClient extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'oauth_clients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['id', 'secret', 'name', 'created_at', 'updated_at'];

    /**
     * The attributes that should be Carbon date mutated
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * Create a new a oauth client
     * 
     * @param string $id
     * @param string $secret
     * @param string $name
     * @return void 
     */
    public function createClient($id, $secret, $name)
    {
    	$client = new $this;

    	$client->id 	= $id;
    	$client->secret = $secret;
    	$client->name 	= $name;

    	$client->save();
    }
}
