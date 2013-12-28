<?php
/**
 * Installer Library.
 *
 * Library for installing the core Fruitful System.
 *
 * @author	Arran Jacques
 */

class Installer {

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
	 * Work out where abouts the user is in the installation process.
	 *
	 * @return	String / Boolean.
	 */
	public function getInstallationStep()
	{
		if (file_exists(app_path() . '/config/database.blank.php'))
		{
			return 'step1';
		}
		else
		{
			if (
				file_exists(app_path() . '/config/database.php') AND
				Schema::hasTable('users') AND
				Schema::hasTable('user_groups') AND
				Schema::hasTable('user_group_permissions')
				)
			{
				return (!$user = \Users_m::find(1)) ? 'step2' : 'step3';
			}
			else
			{
				return 'ERROR';
			}
		}
		return false;
	}

	/**
	 * Attempt to connect to database.
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
	 * Close database connection.
	 *
	 * @return	Void
	 */
	public function closeDatabaseConnection()
	{
		if ($this->dbms == 'mysql')
		{
			mysqli_close($this->connection);
			$this->dbms = null;
			$this->connection = null;
		}
	}

	/**
	 * Test a database connection.
	 *
	 * @param	String
	 * @param	String
	 * @param	String
	 * @param	String
	 * @param	String
	 * @return	Boolean
	 */
	public function testDatabaseConnection($dbms, $host, $port, $username, $password)
	{
		if ($this->connectToDatabase($dbms, $host, $port, $username, $password))
		{
			$this->closeDatabaseConnection();
			return true;
		}
		return false;
	}

	/**
	 * Check if a database already exists.
	 *
	 * @param	String
	 * @return	Boolean
	 */
	public function databaseExists($database)
	{
		if (isset($database))
		{
			if ($this->dbms == 'mysql')
			{
				return mysqli_select_db($this->connection, $database) ? true : false;
			}
		}
		return false;
	}

	/**
	 * Create a new database.
	 *
	 * @param	String
	 * @return	Boolean
	 */
	public function createDatabase($database)
	{
		if (isset($database))
		{
			if ($this->dbms == 'mysql')
			{
				return mysqli_query($this->connection, 'CREATE DATABASE IF NOT EXISTS ' . $database) ? true : false;
			}
		}
		return false;
	}

	/**
	 * Run the migrations to create the core system tables.
	 *
	 * @return	Boolean
	 */
	public function createAndSeedTables()
	{
		Artisan::call('migrate');
		if (Schema::hasTable('users') AND Schema::hasTable('user_groups') AND Schema::hasTable('user_group_permissions'))
		{
			$seeder = new \DatabaseSeeder;
			$seeder->run();
			return true;
		}
		return false;
	}

	/**
	 * Write database connection details to the database.blank.php file.
	 *
	 * @param	Array
	 * @return	Boolean
	 */
	public function writeDatabaseFile(array $details)
	{
		$file = app_path() . '/config/database.blank.php';
		if (is_writable($file))
		{
			$lines = file($file, FILE_IGNORE_NEW_LINES);
			if ($details['dbms'] == 'mysql')
			{
				$lines[28] = '    \'default\' => \'mysql\',';
				$lines[56] = '            \'host\'      => \'' . $details['host'] . '\',';
				$lines[57] = '            \'database\'  => \'' . $details['database'] . '\',';
				$lines[58] = '            \'username\'  => \'' . $details['username'] . '\',';
				$lines[59] = '            \'password\'  => \'' . $details['password'] . '\',';
				$lines[63] = '            \'port\'      => \'' . $details['port'] . '\',';
			}
			$file_contents = '';
			foreach ($lines as $line)
			{
				$file_contents .= $line . PHP_EOL;
			}
			return file_put_contents($file, $file_contents) ?  true : false;
		}
		return false;
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
		for ($i = 0; $i < 32; $i++)
		{
			$encryption_key .= $characters[rand(0, (strlen($characters) - 1))];
		}
		$file = app_path() . '/config/app.php';
		if (is_writable($file))
		{
			$lines = file($file, FILE_IGNORE_NEW_LINES);
			$lines[67] = '    \'key\' => \'' . $encryption_key . '\',';
			$file_contents = '';
			foreach ($lines as $line)
			{
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
	 * Recurse into a directoy and delete all files and directories.
	 *
	 * @param	String
	 * @return	Boolean
	 */
	public function deleteFilesRecursively($directoy)
	{
		if (is_dir($directoy))
		{
			$files = array_diff(scandir($directoy), array('.', '..')); 
			foreach ($files as $file)
			{ 
				(is_dir($directoy . '/' . $file)) ? deleteFilesRecursively($directoy . '/' . $file) : unlink($directoy . '/' . $file); 
			} 
			return rmdir($directoy) ? true : false;
		}
		return true;
	}
}