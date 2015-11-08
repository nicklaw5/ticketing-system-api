<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;

class Account extends Model
{
	use SoftDeletes, Billable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'accounts';

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
    protected $dates = ['deleted_at', 'trial_ends_at', 'subscription_ends_at'];

    /**
     * Tests whether an account exists or not
     * 
     * @param string $subdomain
     * @return bool
     */
    public function exists($subdomain)
    {
    	if($this->findBySubdomain($subdomain))
    		return true;

    	return false;
    }

    /**
     * Gets an account by subdomain
     * 
     * @param string $subdomain
     * @return \App\Model\Account
     */
    public function getBySubdomain($subdomain)
    {
    	return $this->where('subdomain', $subdomain)-first();
    }
}
