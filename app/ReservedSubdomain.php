<?php

namespace App;

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
     * @param type 
     * @return void 
     */
    public function createOrUpdate($attributes)
    {
    	
    }

    /**
     * Returns a subdomain record if exists, or NULL if not
     * 
     * @param string $subdomain 
     * @return mixed 
     */
    public function findBySubdomain($subdomain)
    {
    	return $this->where('subdomain', strtolower($subdomain))->first();
    }

    /**
     * Checks if a given subdomain is reserved
     * 
     * @param string
     * @return bool
     */
    public function isReserved($subdomain)
    {
        if($this->findBySubdomain($subdomain))
            return true;

        return false;
    }
}
