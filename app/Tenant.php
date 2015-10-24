<?php

namespace App;

use DB;
use App;
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
            throw new TenantDatabaseAlreadyExists;
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
}
