<?php

namespace App\Http\Controllers\Admin;

use Validator;
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
        // sanitize passed params and get geo data
        $request = $this->tenant->sanitizeAndExpandRegistrationRequest($request);

        // $this->tenant->setNewTenantDatabaseConnection($request);

        // check subdomain meets length and regex specifications
        if(! $this->tenant->validateSubdomain($request->subdomain))
            throw new InvalidSubdomainException;
        
        // check subdomain is not already taken
        if($this->tenant->findBySudomain($request->subdomain))
            throw new TenantAlreadyExistsException;

        // check subdomain is not reserved
        if($this->reserved_subdomain->isReserved($request->subdomain))
            throw new TenantAlreadyExistsException;

        //**** MADE IT TO HERE ****//
        
        // set the connection to insert the new tenant database
        // $newConnection = $this->tenant->setNewTenantDatabaseConnection($request);
        $connection = $this->tenant->setNewDbConnection($request);

        // count number of table from each database server
        // select database server with the least number of databases
        // create new database for the new tenant
        $this->tenant->createNewTenantDatabase($newConnection['database']);
        
        // perform initaial database table migration
        $this->tenant->runNewTenantMigration($newConnection['database']);
        
        // perform initial database seed


        // $this->tenant->resetDefaultDatabaseConnection();
        
        // add request data to stryve_admin database
        
        // \Artisan::call('migrate:rollback');
        echo 'done';

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
