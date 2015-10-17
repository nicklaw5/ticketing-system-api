<?php 

namespace App\Stryve;

use DB;
use Config;

class ConnectOTF {

	/**
	 * The name of the driver.
	 *
	 * @var string $driver
	 */
	protected $driver;

	/**
	 * The name of the host.
	 *
	 * @var string $host
	 */
	protected $host;

	/**
	 * The port number.
	 *
	 * @var int $port
	 */
	protected $port;

	/**
	 * The name of the database.
	 *
	 * @var string $database
	 */
	protected $database;

	/**
	 * The username needed to connect to the database.
	 *
	 * @var string $username
	 */
	protected $username;

	/**
	 * The password needed to connect to the database.
	 *
	 * @var string $password
	 */
	protected $password;

	/**
	 * The database tables prefix, if any.
	 *
	 * @var string $prefix
	 */
	protected $prefix;

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
	 * Create a new on the fly database
	 * 
	 * @param array $options
	 * @return void
	 */
	public function __construct($options = null)
	{
		// set the connection driver
		$this->setConnectionDriver($options);
		
		// get default connection options based on the set driver
		$default = $this->getDefaultConnectionOptions();

		// replace default options with the options passed in
		foreach($default as $item => $value)
			$default[$item] = isset($options[$item]) ? $options[$item] : $default[$item];

		// set the connection options
		$this->setConnectionOptions($default);

		// create the connection
		$this->setConnection($this->options['database']);
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
		DB::connection($this->getConnectionDriver());
	}

	/**
	 * Sets the connection driver.
	 *
	 * @param array $options
	 * @return void
	 */
	public function setConnectionDriver($options)
	{
		$this->driver = isset($options['driver']) ? $options['driver'] : Config::get('database.default');
	}

	/**
	 * Gets the connection driver.
	 *
	 * @return string
	 */
	public function getConnectionDriver()
	{
		return $this->driver;
	}

	/**
	 * Set the connection options
	 * 
	 * @param array $options
	 * @return void
	 */
	public function setConnectionOptions($options)
	{
		$this->options = Config::set("database.connections.$this->getConnectionDriver", $options);
	}

	/**
	 * Gets the connection driver.
	 *
	 * @return array
	 */
	public function getDefaulConnectiontOptions()
	{
		return Config::get('database.connections' . $this->getConnectionDriver);
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

}