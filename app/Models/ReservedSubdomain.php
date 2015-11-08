<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservedSubdomain extends Model
{
	use SoftDeletes;
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reserved_subdomains';

    /**
     * The attributes that should be mutated to dates.
     * 
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Updates an existing or creates a new
     * reserved subdomain
     * 
     * @param string $subdomain
     * @return void 
     */
    public function createReservedSubdomain($subdomain)
    {
        $domain = new $this;

        $domain->subdomain = $subdomain;

        $domain->save();
    }

    /**
     * Returns a subdomain record if exists, or NULL if not
     * 
     * @param string $subdomain 
     * @return mixed 
     */
    public function findBySubdomain($subdomain)
    {
    	return $this->where('subdomain', lowertrim($subdomain))->first();
    }

    /**
     * Checks if a given subdomain is reserved
     * 
     * @param string $subdomain
     * @return bool
     */
    public function isReserved($subdomain)
    {
        if($this->findBySubdomain($subdomain))
            return true;

        return false;
    }
}
