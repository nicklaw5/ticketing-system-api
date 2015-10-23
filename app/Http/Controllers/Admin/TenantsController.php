<?php

namespace App\Http\Controllers\Admin;

use App\Tenant;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stryve\Requests\NewTenantRequest;

use Stryve\Exceptions\Http\HttpBadRequestExeption;

class TenantsController extends Controller
{
    /**
     * @var \App\Tenant
     */
    protected $tenant;

    /**
     * Instantiate a new instance
     * 
     * @param \App\Tenant
     * @return void
     */
    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
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
     * Registers a new tenant.
     *
     * @param  \Stryve\Requests\NewTenantRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewTenantRequest $request)
    {
        throw new HttpBadRequestExeption;
        // dd($t->getCode());
        // dd($test->getMessage());
        
        dd($request->all());
        /** Request Attributes **/
        // array:6 [
        //   "first_name" => "Nick"
        //   "last_name" => "Law"
        //   "Company" => "Stryve Technologies"
        //   "subdomain" => "stryve"
        //   "phone" => "0423 640 190"
        //   "email" => "nick@stryve.io"
        // ]

        /*********************************/
        /** Tenant Registration Process **/
        /*********************************/

        //  > check subdomain meets length and regex specifications
        //  > check subdomain is not excluded - return on error
        //  > check subdomain isn't already taken - return on error
        //  > check email address doesn't already exist -return on error

        //  > count number of table from each database server
        //  > select database server with the least number of databases
        //  > create new database for the new tenant
        //  > perform initaial database table migration for new tenant
        //  > perform initial database seed for the new tenant (perhaps include some example data)
        //  > 
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
}
