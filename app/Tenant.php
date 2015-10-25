<?php

namespace App;

use DB;
use App;
use GeoIP;
use Config;
use Artisan;

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

    // /**
    //  * @var array
    //  */
    // public $newTenantValidation = [
    //     'full_name' => 'required'
    //     'company'   => 'required'
    //     'subdomain' => 'required'
    //     'phone'     => 'max:16'
    //     'email'     => 'required|email'
    // ];
    
    /**
     * Creates new tenants database
     * 
     * @param string $database 
     * @param string $connection 
     * @return int
     */
    public function createNewTenantDatabase($database)
    {
        try 
        {
            return DB::statement(DB::raw('CREATE DATABASE ' . $database));
        }
        catch(\Exception $e)
        {
            // database probably already exists?
            /** TODO: LOG ERROR **/
            throw new TenantAlreadyExistsException;
        }
    }

    /**
     * Run initial table migration on newly created tenant database.
     * 
     * @param string $connection
     * @param string $database
     * @return void 
     */
    public function runNewTenantMigration($database)
    {
        Artisan::call('migrate', [
            '--database' => $database,
            '--path' => 'app/Stryve/Database/Migrations/Tenant'
        ]);
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

        $full_name              = explode(' ', trim($request->full_name));
        $request->first_name	= array_shift($full_name);        
        $request->last_name     = emptyStringToNull(implode(' ', $full_name));
        $request->email         = trim($request->email);
        $request->phone         = emptyStringToNull($request->phone);
        $request->organisation	= trim($request->organisation);
        $request->subdomain     = lowertrim($request->subdomain);
        $request->database      = replaceHyphens($request->subdomain, '_');

        $request = $this->getUserGeoDataFromRequest($request);
        
        return $request;
    }

    /**
     * Adds geoloacation data to the request based
     * on the passed IP address.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Request $request
     */
    public function getUserGeoDataFromRequest($request)
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
     * Sets the database connection for creating a new tenant
     * database and for running initial table migrations
     * 
     * @param string $subdomain
     * @return array
     */
    public function setNewTenantDatabaseConnection($db_name)
    {
        // get the available connections
        $connections = Config::get('database.connections');

        // get the default connection options
        $defaultConnection = $connections[Config::get('database.default')];

        // clone the default connection options
        $newConnection = $defaultConnection;

        // override the database name to resprsent the new tenant
        $newConnection['database'] = $db_name;

        // set the new database connection
        Config::set('database.connections.'.$db_name, $newConnection);

        // return the new connection options
        return $newConnection;
    }

    /**
     * Determines whether or not the provided subdomain
     * meets subdomain length and character requirements.
     * 
     * @param string $subdomain
     * @return bool
     */
    public function validateSubdomain($subdomain)
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
    public function findBySudomain($subdomain)
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
