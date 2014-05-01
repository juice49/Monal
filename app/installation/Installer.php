<?php
/**
 * Installer Library.
 *
 * Library for installing the core Fruitful System.
 *
 * @author	Arran Jacques
 */

use Illuminate\Database\Schema\Blueprint;

class Installer {

	/**
	 * Instance of class implementing MessagesInterface.
	 *
	 * @var		 Fruitful\Core\Contracts\MessagesInterface
	 */
	protected $messages;

	/**
	 * Database management system.
	 *
	 * @var		String
	 */
	private $dbms;

	/**
	 * Database connection.
	 *
	 * @var		Mixed
	 */
	private $connection;

	/**
	 * Constructor.
	 *
	 * @return	Void
	 */
	public function __construct()
	{
		$this->messages = \App::make('Fruitful\Core\Contracts\MessagesInterface');
	}

	/**
	 * Work out where abouts the user is in the installation process.
	 *
	 * @return	String / Boolean.
	 */
	public function getInstallationStep()
	{
		if (file_exists(app_path() . '/config/database.blank.php')) {
			return 'step1';
		}
		else {
			if (
				file_exists(app_path() . '/config/database.php') AND
				Schema::hasTable('users') AND
				Schema::hasTable('user_groups') AND
				Schema::hasTable('user_group_permissions')
			) {
				return (!$user = \DB::table('users')->find(1)) ? 'step2' : 'step3';
			} else {
				return 'ERROR';
			}
		}
		return false;
	}

	/**
	 * Return installation messages.
	 *
	 * @return	Illuminate\Support\MessageBag
	 */
	public function messages()
	{
		return $this->messages->get();
	}

	/**
	 * Install the system's database.
	 *
	 * @param	Array
	 * @param	Boolean
	 * @return	Boolean
	 */
	public function installDatabase(array $config, $create_database = false)
	{
		$validation = Validator::make(
			$config,
			array(
				'dbms' => 'required',
				'host' => 'required',
				'database' => 'required',
				'username' => 'required',
				'port' => 'required',
			),
			array(
				'dbms.required' => 'You need to tell us what Database Management System you are using.',
				'host.required' => 'You need to tell us the Host Name for your database management system.',
				'database.required' => 'You need to tell us the Name of the database this installation will use.',
				'username.required' => 'You need to tell us the Username to use when connecting to your database.',
				'port.required' => 'You need to tell us the Port Number to use when connecting to your database.',
			)
		);
		if ($validation->passes()) {
			if ($this->connectToDatabase(
				$config['dbms'],
				$config['host'],
				$config['port'],
				$config['username'],
				$config['password']
			)) {
				if ($create_database) {
					if (!$this->createDatabase($config['database'])) {
						$this->messages->add(
							array(
								'error' => array(
									'There was an error creating the database ' . $config['database'] . '. You may need to create it manually.',
								)
							)
						);
						return false;
					}
				} else {
					if (!$this->databaseExists($config['database'])) {
						$this->messages->add(
							array(
								'error' => array(
									'We can’t find a database with the name ' . $config['database'] . '. Tick the box at the bottom if you want us to create it for you.',
								)
							)
						);
						return false;
					}
				}
				if (
					$this->writeToDatabaseFile(
						array(
							'dbms' => $config['dbms'],
							'host' => $config['host'],
							'database' => $config['database'],
							'username' => $config['username'],
							'password' => $config['password'],
							'port' => $config['port'],
						)
					) AND
					$this->renameFile('database.blank.php', 'database.php')
				) {
					$this->createAndSeedTables();
					return true;
				} else {
					$this->messages->add(
						array(
							'error' => array(
								'We were unable to write to the "app/config/database.blank.php" file and rename it. Please check the write permissions for this file and the directory "app/config".'
							)
						)
					);
				}
			} else {
				$this->messages->add(
					array(
						'error' => array(
							'We were unable to connect to the database using these settings. Please check the settings you have provided.'
						)
					)
				);
			}
		} else {
			$this->messages->add($validation->messages()->toArray());
		}
		return false;
	}

	/**
	 * Create the system Admin user.
	 *
	 * @param	Array
	 * @return	Boolean
	 */
	public function createUser(array $details)
	{
		// Allow alpha, spaces and hypen characters. Must also contain at
		// least 1 letter, and cannot begin or end with a space or hyphen.
		Validator::extend('name', function($attribute, $value, $parameters)
		{
			if (
				preg_match('/^[a-z \-]+$/i', $value) AND
				preg_match('/[a-zA-Z]/', $value) AND
				$value[0] != ' ' AND
				$value[0] != '-' AND
				substr($value, -1) != ' ' AND
				substr($value, -1) != '-'
			) {
				return true;
			}
			return false;
		});
		// Allow alpha, numeric, spaces, hypens and underscore characters.
		// Must also contain at least 1 letter or number, and cannot begin or
		// end with a space.
		Validator::extend('username', function($attribute, $value, $parameters)
		{
			if (
				preg_match('/^[a-z0-9 ._\-]+$/i', $value) AND
				(
					preg_match('/[a-zA-Z]/', $value) OR
					preg_match('/[0-9]/', $value)
				) AND
				$value[0] != ' ' AND
				substr($value, -1) != ' '
			) {
				return true;
			}
			return false;
		});
		$validation = Validator::make(
			$details,
			array(
				'first_name' => 'required|name',
				'last_name' => 'required|name',
				'username' => 'required|min:2|username|unique:users',
				'email' => 'required|email|unique:users',
				'password' => 'required|min:6|confirmed',
				),
			array(
				'first_name.required' => 'You need to provide a First Name for yourself.',
				'first_name.name' => 'Your First Name doesn’t look like a name. It can only contain letters, spaces and hyphens, and must contain at least 1 letter. It cannot begin or end with a space or underscore.',
				'last_name.required' => 'You need to provide a Last Name for yourself.',
				'last_name.name' => 'Your Last Name doesn’t look like a name. It can only contain letters, spaces and hyphens, and must contain at least 1 letter. It cannot begin or end with a space or underscore.',
				'username.required' => 'You need to provide a Username for yourself.',
				'username.min' => 'Your Username must be at least two characters long.',
				'username.unique' => 'Sorry, it looks like someone beat you to the punch as this Username is already taken.',
				'username.username' => 'Your Username is invalid. It can only contain letters, numbers, spaces, underscores and hyphens. It must contain at least 1 letter or number and cannot begin or end with spaces.',
				'email.required' => 'You need to provide an Email Address for yourself.',
				'email.email' => 'Your Email Address doesn’t look like a valid email address.',
				'email.unique' => 'Sorry, it looks like someone beat you to the punch as this Email Address is already taken.',
				'password.required' => 'You need to provide a Password for your account.',
				'password.min' => 'Your Password must be at least 6 characters long.',
				'password.confirmed' => 'Your Passwords don’t appear to match.',
				)
		);
		if ($validation->passes()) {
			if ($this->writeEncryptionKey()) {
				\DB::table('users')->insert(array(
					'first_name' => $details['first_name'],
					'last_name' => $details['last_name'],
					'username' => $details['username'],
					'email' => $details['email'],
					'password' => \Hash::make($details['password']),
					'group' => 1,
					'active' => 1,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
					)
				);
				return true;
			}
			$this->messages->add(
				array(
					'error' => array(
						'There was an error writing the encryption key to the "app/config/app" file. Please check the write permissions for this file and for the directory "app/config".'
					)
				)
			);
		} else {
			$this->messages->add($validation->messages()->toArray());
		}
		return false;
	}

	/**
	 * Delete the system's installation files.
	 *
	 * @return	Boolean
	 */
	public function deleteInstallationFiles()
	{
		if ($this->deleteFilesRecursively(app_path() . '/views/installation')) {
			if ($this->deleteFilesRecursively(app_path() . '/installation')) {
				return true;
			}
			$this->messages->add(
				array(
					'error' => array(
						'We were unable to remove the directory "app/installation" and its sub directories and files. You may need to remove it manually.'
					)
				)
			);
		} else {
			$this->messages->add(
				array(
					'error' => array(
						'We were unable to remove the directory "app/views/installation" and its sub directories and files. You may need to remove it manually.'
					)
				)
			);
		}
		return false;
	}

	/**
	 * Connect to the database.
	 *
	 * @param	String
	 * @param	String
	 * @param	String
	 * @param	String
	 * @param	String
	 * @return	Mixed / Boolean
	 */
	public function connectToDatabase($dbms, $host, $port, $username, $password)
	{
		if ($dbms == 'mysql')
		{
			$this->dbms = $dbms;
			$this->connection = @mysqli_connect($host, $username, $password, null, $port);
			return ($this->connection) ? $this->connection : false;
		}
		return false;
	}

	/**
	 * Close the database connection.
	 *
	 * @return	Void
	 */
	public function closeDatabaseConnection()
	{
		if ($this->dbms == 'mysql') {
			mysqli_close($this->connection);
			$this->dbms = null;
			$this->connection = null;
		}
	}

	/**
	 * Check if a database already exists.
	 *
	 * @param	String
	 * @return	Boolean
	 */
	public function databaseExists($database_name)
	{
		if ($this->dbms == 'mysql') {
			return mysqli_select_db($this->connection, $database_name) ? true : false;
		}
		return false;
	}

	/**
	 * Create a new database.
	 *
	 * @param	String
	 * @return	Boolean
	 */
	public function createDatabase($database_name)
	{
		if ($this->dbms == 'mysql') {
			return mysqli_query($this->connection, 'CREATE DATABASE IF NOT EXISTS ' . $database_name) ? true : false;
		}
		return false;
	}

	/**
	 * Create the core system tables and seed them.
	 *
	 * @return	Void
	 */
	public function createAndSeedTables()
	{
		\Schema::create(
			'users',
			function(Blueprint $table) {
				$table->increments('id');
				$table->string('first_name', 255)->nullable();
				$table->string('last_name', 255)->nullable();
				$table->string('username', 255)->nullable()->unique();
				$table->string('email', 255)->nullable()->unique();
				$table->string('password', 255)->nullable();
				$table->integer('group')->nullable();
				$table->boolean('active')->nullable();
				$table->string('remember_token', 255)->nullable();
				$table->timestamps();
			}
		);
		\Schema::create(
			'user_groups',
			function(Blueprint $table) {
				$table->increments('id');
				$table->string('name', 255)->nullable();
				$table->timestamps();
			}
		);
		\Schema::create(
			'user_group_permissions',
			function(Blueprint $table) {
				$table->increments('id');
				$table->integer('group')->nullable();
				$table->boolean('admin')->nullable();
				$table->text('admin_permissions')->nullable();
				$table->timestamps();
			}
		);
		\DB::table('user_groups')->insert(array(
			'name' => 'Administrator',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			)
		);
		\DB::table('user_group_permissions')->insert(array(
			'group' => '1',
			'admin' => '1',
			'admin_permissions' => null,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
			)
		);
	}

	/**
	 * Write the database connection details to the database.blank.php
	 * file.
	 *
	 * @param	Array
	 * @return	Boolean
	 */
	public function writeToDatabaseFile(array $details)
	{
		$file = app_path() . '/config/database.blank.php';
		if (is_writable($file)) {
			$lines = file($file, FILE_IGNORE_NEW_LINES);
			if ($details['dbms'] == 'mysql') {
				$lines[28] = '    \'default\' => \'mysql\',';
				$lines[56] = '            \'host\'      => \'' . $details['host'] . '\',';
				$lines[57] = '            \'database\'  => \'' . $details['database'] . '\',';
				$lines[58] = '            \'username\'  => \'' . $details['username'] . '\',';
				$lines[59] = '            \'password\'  => \'' . $details['password'] . '\',';
				$lines[63] = '            \'port\'      => \'' . $details['port'] . '\',';
			}
			$file_contents = '';
			foreach ($lines as $line) {
				$file_contents .= $line . PHP_EOL;
			}
			return file_put_contents($file, $file_contents) ?  true : false;
		}
		return false;
	}

	/**
	 * Rename a config file.
	 *
	 * @return	Boolean
	 */
	public function renameFile($from, $to)
	{
		return rename(app_path() . '/config/' . $from, app_path() . '/config/' . $to) ? true : false;
	}

	/**
	 * Generate random encryption key and write it to the app.php file.
	 *
	 * @return	Boolean
	 */
	public function writeEncryptionKey()
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@£$%^&*()_+-=[];\,./<>?:|{};';
		$encryption_key = '';
		for ($i = 0; $i < 32; $i++) {
			$encryption_key .= $characters[rand(0, (strlen($characters) - 1))];
		}
		$file = app_path() . '/config/app.php';
		if (is_writable($file)) {
			$lines = file($file, FILE_IGNORE_NEW_LINES);
			$lines[80] = '    \'key\' => \'' . $encryption_key . '\',';
			$file_contents = '';
			foreach ($lines as $line) {
				$file_contents .= $line . PHP_EOL;
			}
			return file_put_contents($file, $file_contents) ?  true : false;
		}
		return false;
	}

	/**
	 * Recurse into a directoy and delete all files and directories.
	 *
	 * @param	String
	 * @return	Boolean
	 */
	public function deleteFilesRecursively($directoy)
	{
		if (is_dir($directoy)) {
			$files = array_diff(scandir($directoy), array('.', '..')); 
			foreach ($files as $file) { 
				(is_dir($directoy . '/' . $file)) ? deleteFilesRecursively($directoy . '/' . $file) : unlink($directoy . '/' . $file); 
			} 
			return rmdir($directoy) ? true : false;
		}
		return true;
	}
}