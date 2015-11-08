<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'organizations';

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
    protected $hidden = [];

    /**
     * @var array
     */
    protected $dates = [];

    /**
     * Tests whether an organisation exists or not
     * 
     * @param string $subdomain
     * @return bool
     */
    public function exists($subdomain)
    {
    	//
    }

    /**
     * Gets an organization by subdomain
     * 
     * @param string $subdomain
     * @return \App\Model\Organization
     */
    public function getBySubdomain($subdomain)
    {
    	//
    }


}
