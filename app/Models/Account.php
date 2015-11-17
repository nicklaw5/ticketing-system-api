<?php

namespace App\Models;

use GeoIP;

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
     * The attributes that should be Carbon date mutated
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'trial_ends_at', 'subscription_ends_at'];
    
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

    /**
     * Santizes and expands on the register params
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Request $request
     */
    public function sanitizeAndExpandRegistrationRequest($request)
    {
        /** Request Attributes **/
        // array:6 [
        //   "full_name" => "Nick Law"
        //   "company" => "Stryve Technologies"
        //   "subdomain" => "stryve_tech"
        //   "phone" => "0423 640 190" (optional)
        //   "email" => "nick@stryve.io"
        // ]

        $request->full_name         = trim($request->full_name);        
        $request->email             = trim($request->email);
        $request->phone             = emptyStringToNull($request->phone);
        $request->organisation      = trim($request->organisation);
        $request->subdomain         = lowertrim($request->subdomain);
        $request->database          = replaceHyphens($request->subdomain, '_');
        $request->database_prefix   = generateRandomString(3).'_';
        $request->client_locale     = getClientLocale();

        $request = $this->addUserGeoDataToRequest($request);
        
        return $request;
    }

    /**
     * Adds geoloacation data to the request based
     * on the passed IP address.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Request $request
     */
    public function addUserGeoDataToRequest($request)
    {
        // get geo data
        $geo = arrayToStdClassObject(GeoIP::getLocation('120.149.144.13'/*$request->ip*/));

        // EXAMPLE:
        // isoCode "AU"
        // country "Australia"
        // city "South Yarra"
        // state "VIC"
        // postal_code "3141"
        // lat -37.8333
        // lon 144.9833
        // timezone "Australia/Melbourne"
        // continent "OC"

        // did we get valid data (true == false)
        $isValidData = ($geo->default)? false: true;

        // set request param
        foreach ($geo as $key => $value)
            $request->{$key} = ($isValidData)? $value : null;

        return $request;
    }

    /**
     * Determines whether or not the provided subdomain
     * meets subdomain length and character requirements.
     * 
     * @param string $subdomain
     * @return bool
     */
    public function isValidSubdomain($subdomain)
    {
        $subdomain = lowertrim($subdomain);
        $min_length = Config::get('stryve.tenant.subdomain-min-length');
        $max_length = Config::get('stryve.tenant.subdomain-max-length');
        $subdomain_length = strlen($subdomain);

        // check subdomain is of valid characters
        if(! isValidSubdomain($subdomain))
            return false;

        // check subdomain meets length requirements
        if($subdomain_length < $min_length || $subdomain_length > $max_length)
            return false;

        return true;
    }

    /**
     * Create a new account
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function createAccount($request)
    {

    }
}
