<?php 

namespace Stryve\Database;

use DB;
use Config;

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
	 * Create a new on the fly database connection
	 * 
	 * @param string $connection_name
	 * @param array $options
	 * @return void
	 */
	public function __construct($options = [], $connection_name = null)
	{
		// set default options so we can revert back to them later
		$this->setDefaultOptions();

		// set the connection name
		$this->setConnectionName($connection_name);

		// set the new connection options
		$this->setConnectionOptions($options);

		// dd($this->getConnectionOptions());

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
	 * @param array $default
	 * @param array $options
	 * @return void
	 */
	protected function setDefaultOptions()
	{
		$default = Config::get('database.default');

		$this->default_options = Config::get('database.connections.'.$default);
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
		$this->connection = DB::connection($this->getConnectionName());
	}

	/**
	 * Sets the connection name.
	 *
	 * @param array $options
	 * @return void
	 */
	public function setConnectionName($connection_name)
	{
		// if connection name set, check it exists
		if($connection_name !== null)
			$name = Config::get('database.connections.'.$connection_name);
		else
			$name = Config::get('database.default');

		if($name === null)
			throw new NoDatabaseConnectionFoundExceptoion;

		$this->connection_name = $name;
	}

	/**
	 * Gets the connection name
	 * 
	 * @param string
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


	// // from -> http://laravel.io/forum/09-13-2014-create-new-database-and-tables-on-the-fly
	// /**
	//  * Creates a new database schema.
	//  *
	//  * @param  string $schemaName The new schema name.
	//  * @return bool
	//  */
	// function createSchema($schemaName)
	// {
	//     // We will use the `statement` method from the connection class so that
	//     // we have access to parameter binding.
	//     return DB::getConnection()->statement('CREATE DATABASE :schema', array('schema' => $schemaName));
	// }

}