<?php 

namespace Stryve\Database;

use DB;
use Config;

use Stryve\Exceptions\TenantAlreadyExistsException;
use Stryve\Exceptions\NoDatabaseConnectionFoundExceptoion;

class ConnectOTF {

	/**
	 * The on the fly database connection.
	 *
	 * @var \Illuminate\Database\Connection
	 */
	protected $connection;

	/**
	 * The database connection options.
	 *
	 * @param  array $options
	 * @return void
	 */
	protected $options;

	/**
	 * The default database connection options
	 *
	 * @var array
	 */
	protected $default_options;

	/**
	 * The name given to the connection
	 *
	 * @var string
	 */
	protected $connection_name;

	// $options = [
	// 	'driver'	=> 'pgsql', // or 'mysql'
	// 	'host' 		=> $value,
	// 	'port'		=> $value,
	// 	'database' 	=> $value,
	// 	'username'	=> $value,
	// 	'password' 	=> $value,
	// 	'charset' 	=> $value,
	// 	'prefix' 	=> $value,
	// 	'schema'	=> $value
	// ];

	/**
	 * Create a new on-the-fly database connection
	 * 
	 * @param string $connection_name
	 * @param array $options
	 * @return void
	 */
	public function __construct($options = [], $connection_name = null)
	{	
		// set the connection name
		$this->setConnectionName($connection_name);

		// set default options so we can revert back to them later
		$this->setDefaultOptions();

		// set the new connection options
		$this->setConnectionOptions($options);

		// create the connection
		$this->setConnection();
	}

	/**
	 * Gets the default connection options
	 * 
	 * @return array
	 */
	public function getDefaultOptions()
	{
		return $this->default_options;
	}

	/**
	 * Sets the default connection options
	 * 
	 * @return void
	 */
	protected function setDefaultOptions()
	{
		$this->default_options = Config::get('database.connections.'.$this->getConnectionName());
	}

	/**
	 * Gets the connection options
	 * 
	 * @return array
	 */
	public function getConnectionOptions()
	{
		return $this->options;
	}

	/**
	 * Set the connection options
	 * 
	 * @param array $options
	 * @return void
	 */
	public function setConnectionOptions($options)
	{
		// get the default options
		$default = $this->getDefaultOptions();

		// replace default options with those passed in
		foreach($default as $item => $value)
			$default[$item] = isset($options[$item]) ? $options[$item] : $default[$item];
		

		// set the new connetion options
		Config::set('database.connections'.$this->getConnectionName(), $default);
		$this->options = Config::get('database.connections'.$this->getConnectionName());
		// dd($this->getConnectionName());

		// dd($this->getConnectionOptions());
		// $this->options = $default;
	}

	/**
	 * Get the on the fly connection.
	 *
	 * @return \Illuminate\Database\Connection
	 */
	public function getConnection()
	{
		return $this->connection;
	}

	/**
	 * Set the database connection
	 * 
	 * @return void
	 */
	public function setConnection()
	{
		// dd($this->getConnectionName());
		// check connection exixts
		if(null === Config::get('database.connections.'.$this->getConnectionName()))
			throw new NoDatabaseConnectionFoundExceptoion;

		dd(Config::get('database.connections.'.$this->getConnectionName()));

		$this->connection = DB::connection($this->getConnectionName());
	}

	/**
	 * Sets the connection name.
	 *
	 * @param array $connection_name
	 * @return void
	 */
	public function setConnectionName($connection_name)
	{
		$this->connection_name = ($connection_name !== null)? $connection_name : Config::get('database.default');
	}

	/**
	 * Gets the connection name
	 * 
	 * @return string
	 */
	public function getConnectionName()
	{
		return $this->connection_name;
	}

	/**
	 * Gets the default connection options.
	 *
	 * @return array
	 */
	public function getDefaultConnectionOptions()
	{
		// return Config::get('database.connections' . $this->getConnectionDriver);
		$default = Config::get('database.default');

		return Config::get('database.connections.'.$default);
	}

	/**
	 * Get a table from the on the fly connection.
	 *
	 * @var    string $table
	 * @return \Illuminate\Database\Query\Builder
	 */
	public function getTable($table = null)
	{
		return $this->getConnection()->table($table);
	}

	/**
     * Creates new database
     * 
     * @throws \Stryve\Exceptions\TenantAlreadyExistsException
     * @param string $database
     * @return int
     */
    public function createDatabase($database)
    {
        try 
        {
            return $this->getConnection()->statement(DB::raw('CREATE DATABASE ' . $database));
        }
        catch(\Exception $e)
        {
            // database probably already exists?
            /** TODO: LOG ERROR **/
            throw new TenantAlreadyExistsException;
        }
    }

}