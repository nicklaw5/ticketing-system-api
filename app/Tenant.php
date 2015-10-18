<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;


class Tenant extends Model implements BillableContract
{
    use Billable;

    /**
     * @var $date
     */
    protected $dates = ['trial_ends_at', 'subscription_ends_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tenants';

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
}
