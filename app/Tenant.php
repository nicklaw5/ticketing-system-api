<?php

namespace App;

use DB;
use App;
use GeoIP;
use Config;
use Artisan;

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
     * @param string $db_name 
     * @param string $connection 
     * @return int
     */
    public function createNewTenantDb($db_name)
    {
        try 
        {
            return DB::statement(DB::raw('CREATE DATABASE ' . $db_name));
        }
        catch(\Exception $e)
        {
            /** TODO: LOG ERROR **/
            throw new TenantAlreadyExistsException;
        }
    }

    /**
     * Run initial table migration on newly created tenant database.
     * 
     * @param string $connection
     * @param string $db_name
     * @return void 
     */
    public function runNewTenantMigration($db_name)
    {
        Artisan::call('migrate', [
            '--database' => $db_name,
            '--path' => 'app/Stryve/Database/Migrations/Tenant'
        ]);
    }

    /**
     * Santizes and expands on the register params
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Request $request
     */
    public function sanitizeAndExpandRegistrationRequest($request)
    {
        /** Request Attributes **/
        // array:6 [
        //   "full_name" => "Nick Law"
        //   "company" => "Stryve Technologies"
        //   "subdomain" => "stryve"
        //   "phone" => "0423 640 190"
        //   "email" => "nick@stryve.io"
        // ]
        

        $full_name              = explode(' ', trim($request->full_name));
        $request->first_name    = $full_name[0];
        $request->last_name     = emptyStringToNull(implode(' ', array_shift($full_name)));
        $request->email         = trim($request->email);
        $request->phone         = emptyStringToNull($request->phone);

        $request->company       = trim($request->company);
        $request->subdomain     = lowertrim($request->subdomain);
        $request->db_name       = replaceHyphens($request->subdomain, '_');

        $geo = arrayToStdClassObject(GeoIP::getLocation($request->ip));

		// isoCode "AU"
		// country "Australia"
		// city "South Yarra"
		// state "VIC"
		// postal_code "3141"
		// lat -37.8333
		// lon 144.9833
		// timezone "Australia/Melbourne"
		// continent "OC"
		
        $request->ip 			= $geo->ip;
        $request->isoCode		= $geo->isoCode;
        $request->country		= $geo->country;
        $request->city			= $geo->city;
        $request->state			= $geo->state;
        $request->post_code		= $geo->post_code;
        $request->lat			= $geo->lat;
        $request->long			= $geo->long;
        $request->timezone		= $geo->timezone;
        $request->continent		= $geo->continent;
        
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
        $max_length = Config::get('stryve.tenant.subdomain-length');

        // check subdomain meets length requirements
        if(strlen($subdomain) > $max_length)
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
