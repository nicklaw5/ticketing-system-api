<?php

namespace App\Models;

use DB;
use App;
use GeoIP;
use Config;
use Artisan;

use Stryve\Database\ConnectOTF;
use Stryve\Exceptions\TenantAlreadyExistsException;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;

// EXCEPTIONS
use Stryve\Exceptions\TenantDatabaseAlreadyExists;

class Tenant extends Model implements BillableContract
{
    use SoftDeletes, Billable;
    
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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'trial_ends_at', 'subscription_ends_at'];

    /**
     * Create new tenants database
     * 
     * @throws \Stryve\Exceptions\TenantAlreadyExistsException;
     * @param string $database
     * @return int
     */
    public function createNewTenantDatabase($database)
    {
        try 
        {
            return DB::statement('CREATE DATABASE ' . $database);
        }
        catch(\Exception $e)
        {
            // database probably already exists?
            /** TODO: LOG ERROR **/
            throw new TenantAlreadyExistsException;
        }
    }

    /**
     * Run new tenant table migration.
     * 
     * @param string $connection
     * @param string $database
     * @return void
     */
    public function runNewTenantMigration($database)
    {
        try
        {
            Artisan::call('migrate', [
                '--database' => $database,
                '--path' => 'app/Stryve/Database/Migrations/Tenant'
            ]);
        }
        catch (Exception $e)
        {
            /** TODO: LOG ERROR **/
            throw new FailedTenantMigrationException;
            
        }
    }

    /**
     * Run new tenant table seeder
     * 
     * @param 
     * @return void
     */
    public function runNewTenantTableSeeder($database)
    {   
        $class = 'Stryve/Database/Seeds/NewTenantDatabaseSeeder';

        try
        {
            Artisan::call('db:seed', [
                '--class' => $class,
                '--database' => $database
            ]);
        }
        catch (Exception $e)
        {
            /** TODO: LOG ERROR **/
            throw new FailedTenantMigrationException;
            
        }
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

        $full_name              	= explode(' ', trim($request->full_name));
        $request->first_name		= array_shift($full_name);        
        $request->last_name     	= emptyStringToNull(implode(' ', $full_name));
        $request->email         	= trim($request->email);
        $request->phone         	= emptyStringToNull($request->phone);
        $request->organisation		= trim($request->organisation);
        $request->subdomain         = lowertrim($request->subdomain);
        $request->database          = replaceHyphens($request->subdomain, '_');
        $request->database_prefix   = generateRandomString(3).'_';

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
    	$geo = arrayToStdClassObject(GeoIP::getLocation($request->ip));

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

    	// did we get valid data (true = false)
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

        // check subdomain meets length requirements
        if($subdomain_length < $min_length || $subdomain_length > $max_length)
            return false;

        // check subdomain is of valid characters
        if(! isValidSubdomain($subdomain))
            return false;

        return true;
    }

    /**
     * Returns a tenant record if exists, or NULL if not
     * 
     * @param string $subdomain
     * @return mixed
     */
    public function findBySubdomain($subdomain)
    {
        return $this->where('subdomain', lowertrim($subdomain))->first();
    }

    /**
     * Checks if a tenant exists
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
}
