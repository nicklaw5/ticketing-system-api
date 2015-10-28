<?php

namespace App\Http\Controllers\Admin;

use App\Tenant;
use App\ReservedSubdomain;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Stryve\Database\ConnectOTF;

use Stryve\Requests\NewTenantRequest;
use Stryve\Response\ApiResponses;

use Stryve\Exceptions\InvalidSubdomainException;
use Stryve\Exceptions\TenantAlreadyExistsException;

class TenantsController extends Controller
{
    /**
     * @var \App\Tenant
     */
    protected $tenant;

    /**
     * @var \Illuminate\Database\Connection
     */
    protected $connection;

    /**
     * @var \App\ReservedSubdomain
     */
    protected $reserved_subdomain;

    /**
     * Instantiate a new instance
     * 
     * @param \App\Tenant
     * @return void
     */
    public function __construct(Tenant $tenant, ReservedSubdomain $reserved_subdomain)
    {
        $this->tenant = $tenant;
        $this->reserved_subdomain = $reserved_subdomain;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Register a new tenant.
     *
     * @throws \Stryve\Exceptions\InvalidSubdomainException;
     * @throws \Stryve\Exceptions\TenantAlreadyExistsException;
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response (HTTP 201 Created)
     */
    public function store(Request $request)
    {
        // \DB::connection('svr1');

        // \Config::get

        // dd(\DB::connection('svr2'));


        // sanitize passed params and get geo data
        $request = $this->tenant->sanitizeAndExpandRegistrationRequest($request);

        $subdomain = $request->subdomain;
        $database = $request->database;
        $database_prefix = $request->database_prefix;

        // check subdomain meets length and regex specifications
        if(! $this->tenant->isValidSubdomain($subdomain))
            throw new InvalidSubdomainException;
        
        // check subdomain is not already taken
        if($this->tenant->exists($subdomain))
            throw new TenantAlreadyExistsException;

        // check subdomain is not reserved
        if($this->reserved_subdomain->isReserved($subdomain))
            throw new TenantAlreadyExistsException;

        // set the connection options
        $options = [
            'database'  => $database,
            'prefix'    => $database_prefix
        ];

        // get the default connection detail so we can revert back
        $defaultConnection = getDefaultDatabaseConnetion();

        // set the new connection
        setDatabaseConnetion($database, $options);

        // create the new tenants database
        $this->tenant->createNewTenantDatabase($database);

        // run the new tenant migration
        $this->tenant->runNewTenantMigration($database);

        // \DB::disconnect($request->database);
        // dd(\DB::connection('svr1'));

        // run new tenant seeder
        $this->tenant->runNewTenantTableSeeder($database);

        // reset the default database connection
        // setDatabaseConnetion($defaultConnection['connection'], $defaultConnection['options']);
        

        // $default = \Config::get('database.default');
        // dd(\Config::get('database.connections.' . $default));

        exit('done');


        // \DB::statement(\DB::raw('CREATE DATABASE ' . $request->database));

        // \Artisan::call('migrate', [
        //     '--database' => $request->database,
        //     '--path' => 'app/Stryve/Database/Migrations/Tenant'
        // ]);


        //

        /***/
        // // Will contain the array of connections that appear in our database config file.
        // $connections = \Config::get('database.connections');

        // // This line pulls out the default connection by key (by default it's `mysql`)
        // $defaultConnection = $connections[\Config::get('database.default')];

        // // Now we simply copy the default connection information to our new connection.
        // $newConnection = $defaultConnection;

        // $options = [
        //     'database'  => $request->database,
        //     'prefix'    => $request->database_prefix
        // ];

        // // Override the database name.
        // foreach($newConnection as $item => $value)
        //     $newConnection[$item] = isset($options[$item]) ? $options[$item] : $newConnection[$item];

        // // dd($newConnection);

        // // $newConnection['database'] = $request->database;

        // // This will add our new connection to the run-time configuration for the duration of the request.
        // \Config::set('database.connections.'.$request->database, $newConnection);
        /***/




        // count number of table from each database server
        // select database server with the least number of databases

        // // set the default connections options so we can revert back
        // $conn_name = \Config::get('database.default');
        // $defaultOptions = \Config::get('database.connections.'.$conn_name);

        // // clone the default options
        // $default = $defaultOptions;

        // // the new conneciton options
        // $options = [
        //     'database'  => $request->database,
        //     'prefix'    => $request->database_prefix
        // ];

        // // replace default options
        // foreach($default as $item => $value)
        //     $default[$item] = isset($options[$item]) ? $options[$item] : $default[$item];

        // // set the new connection
        // \Config::set('database.connections.'.$conn_name, $default);

        // try inserting new tenant DB
        \DB::statement(\DB::raw('CREATE DATABASE ' . $request->database));

        // dd(\Config::get('database.connections.db_svr_0'));

        // $this->tenant->runNewTenantMigration($request->database);
        
        // run new tenant migration
        \Artisan::call('migrate', [
            '--database' => $conn->getConnectionName(),
            '--path' => 'app/Stryve/Database/Migrations/Tenant'
        ]);

        // \Config::set('database.connections.'.\Config::get('database.default'), $defaultConnection);

        // dd(\Config::get('database.connections.'.\Config::get('database.default')));

        exit('done');
        
        // set the connection to insert the new tenant database
        // $connection = new ConnectOTF($options); // $this->tenant->setNewDbConnection($request);

        // dd($connection->getDefaultOptions());

        // create new tenant database
        // $connection->createDatabase($request->database);

        // dd(\Config::get('database.connections.'.$connection->getConnectionName()));


        // perform initaial database table migration
        
        // perform initial database seed

        // reset the connection bac to its default
        // $connection->getConnection()->resetDefaultConnection();
        
        
        // add request data to stryve_admin database
        
        // \Artisan::call('migrate:rollback');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Tests if tenants is active
     * 
     * @param string $string
     * @return bool
     */
    public function tenantExists($string)
    {
        //
    }

    /**
     * Gets the value of reserved_subdomain.
     *
     * @return \App\ReservedSubdomain
     */
    public function getReservedSubdomain()
    {
        return $this->reserved_subdomain;
    }
}
