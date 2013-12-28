<?php
/**
 * Installation Controller
 *
 * Controller for installation pages.
 *
 * @author	Arran Jacques
 */

use Fruitful\Core\Contracts\GatewayInterface;

class InstallationController extends BaseController {

	/**
	 * Instance class that implements the GatewayInterface inteface.
	 *
	 * @var		Fruitful\Core\GatewayInterface
	 */
	protected $system;

	/**
	 * Instance of Installer class.
	 *
	 * @var		Installer
	 */
	protected $installer;

	/**
	 * Input data.
	 *
	 * @var		Array
	 */
	public $input;

	/**
	 * Initialise class.
	 *
	 * @param	Fruitful\Core\Contracts\GatewayInterface
	 * @param	Installer
	 * @return	Void
	 */
	public function __construct(GatewayInterface $system_gateway, Installer $installer)
	{
		$this->system = $system_gateway;
		$this->installer = $installer;
		$this->input = Input::all();

		Validator::extend('name', function($attribute, $value, $parameters)
		{
		    return (preg_match('/^[a-z .\-]+$/i', $value) AND preg_match('/[a-zA-Z]/', $value)) ? true : false;
		});
		Validator::extend('username', function($attribute, $value, $parameters)
		{
		    return (preg_match('/^[a-z0-9 .\-_]+$/i', $value)) ? true : false;
		});
	}

	/**
	 * Control and display installation database page.
	 *
	 * @return	Illuminate\View\View
	 */
	public function database()
	{
		if ($this->input)
		{
			if (Session::token() != $this->input['_token'])
			{
				throw new Illuminate\Session\TokenMismatchException;
			}

			$validation = Validator::make($this->input,
				array(
					'dbms' => 'required',
					'host' => 'required',
					'database' => 'required',
					'username' => 'required',
					'password' => 'required',
					'port' => 'required',
					),
				array(
					'dbms.required' => 'You need to tell us what database management system you are using.',
					'host.required' => 'You need to tell us the host name for your database management system.',
					'database.required' => 'You need to tell us the name of the database this installation will use.',
					'username.required' => 'You need to provide us with a username to use when connecting to your database.',
					'password.required' => 'You need to provide us with a password to use when connecting to your database.',
					'port.required' => 'You need to tell us what port number to use when connecting to your database.',
					)
				);

			if ($validation->passes())
			{
				if ($this->installer->testDatabaseConnection(
					$this->input['dbms'],
					$this->input['host'],
					$this->input['port'],
					$this->input['username'],
					$this->input['password']
					))
				{
					$this->installer->connectToDatabase(
						$this->input['dbms'],
						$this->input['host'],
						$this->input['port'],
						$this->input['username'],
						$this->input['password']
						);
					$write_file = true;
					if (isset($this->input['create']) AND !$this->installer->createDatabase($this->input['database']))
					{
						$write_file = false;
						$this->system->messages->setMessages(array(
							'error' => array(
								'Oops! We was able to connect to the database; however there was an error creating the new database ' . $this->input['database'] . '. You may need to create the new database manually.'
								)
							));
					}
					else if (!isset($this->input['create']) AND !$this->installer->databaseExists($this->input['database']))
					{
						$write_file = false;
						$this->system->messages->setMessages(array(
							'error' => array(
								'Oops! We was able to connect to the database; however there appears to be no database with the the name ' . $this->input['database'] . '. Tick the box at the bottom if you want us to try and create it for you.'
								)
							));
					}
					$this->installer->closeDatabaseConnection();

					if ($write_file)
					{
						if ($this->installer->writeDatabaseFile(array(
							'dbms' => $this->input['dbms'],
							'host' => $this->input['host'],
							'database' => $this->input['database'],
							'username' => $this->input['username'],
							'password' => $this->input['password'],
							'port' => $this->input['port'],
							)) AND
							$this->installer->renameFile('database.blank.php', 'database.php')
							)
						{
							if ($this->installer->createAndSeedTables())
							{
								return Redirect::route('installation.user');
							}
							else
							{
								$this->installer->renameFile('database.php', 'database.blank.php');
								$this->system->messages->setMessages(array(
									'error' => array(
										'Oops! We configured your database settings correctly; however there was an error running the migrations. Please try again.'
										)
									));
							}
						}
						else
						{
							$this->system->messages->setMessages(array(
								'error' => array(
									'Oops! We were unable to write to the database.blank.php file and rename it in the "app/config" directory. Please check the write permissions for this directory and file.'
									)
								));
						}
					}
				}
				else
				{
					$this->system->messages->setMessages(array(
						'error' => array(
							'Oops! We were unable to connect to the database using these settings. Please check the settings you have provided.'
							)
						));
				}
			}
			else
			{
				$this->system->messages->setMessages($validation->messages()->toArray());
			}
		}
		$database_management_systems = array(
			'mysql' => 'MySQL'
			);
		$messages = $this->system->messages->getMessages();
		return View::make('installation.database', compact('messages', 'database_management_systems'));
	}

	/**
	 * Control and display installation user page.
	 *
	 * @return	Illuminate\View\View
	 */
	public function user()
	{
		if ($this->input)
		{
			if (Session::token() != $this->input['_token'])
			{
				throw new Illuminate\Session\TokenMismatchException;
			}

			$validation = Validator::make($this->input,
				array(
					'first_name' => 'required|name',
					'last_name' => 'required|name',
					'username' => 'required|min:2|username|unique:users',
					'email' => 'required|email|unique:users',
					'password' => 'required|min:6|confirmed',
					),
				array(
					'first_name.required' => 'You need to provide a First Name for yourself.',
					'first_name.name' => 'Your First Name can only contain letters, spaces or hyphens, and must contain at least one letter.',
					'last_name.required' => 'You need to provide a Last Name for yourself.',
					'last_name.name' => 'Your Last Name can only contain letters, spaces or hyphens, and must contain at least one letter.',
					'username.required' => 'You need to provide a Username for yourself.',
					'username.min' => 'Your Username must be at least two characters long.',
					'username.unique' => 'Sorry, it looks like someone beat you to the punch as this Username is already taken.',
					'username.username' => 'Your Username can only contain letters, numbers, spaces, underscores or hyphens.',
					'email.required' => 'You need to provide an Email Address for yourself.',
					'email.email' => 'Your Email Address doesn’t appear to be a valid email address.',
					'email.unique' => 'Sorry, it looks like someone beat you to the punch as this Email Address is already taken.',
					'password.required' => 'You need to provide a Password for your account.',
					'password.min' => 'Your Password must be at least 6 characters long.',
					'password.confirmed' => 'Your Passwords don’t appear to match.',
					)
				);

			if ($validation->passes())
			{
				if ($this->installer->writeEncryptionKey())
				{
					if (\Users_m::createUser(array(
						'first_name' => $this->input['first_name'],
						'last_name' => $this->input['last_name'],
						'username' => $this->input['username'],
						'email' => $this->input['email'],
						'password' => $this->input['password'],
						'group' => 1,
						'active' => 1,
						))
						)
					{
						return Redirect::route('installation.remove');
					}
					else
					{
						$this->system->messages->setMessages(array(
							'error' => array(
								'Oops! Your details are ok; however there was an error saving your details to the database. Please try again.'
								)
							));
					}
				}
				else
				{
					$this->system->messages->setMessages(array(
						'error' => array(
							'Oops! We were unable to write your encryption key to the app.php file. Please check the write permissions for this directory and file.'
							)
						));
				}
			}
			else
			{
				$this->system->messages->setMessages($validation->messages()->toArray());
			}
		}
		$messages = $this->system->messages->getMessages();
		return View::make('installation.user', compact('messages'));
	}

	/**
	 * Control and display installation remove page.
	 *
	 * @return	Illuminate\View\View
	 */
	public function remove()
	{
		if (isset($this->input['remove']))
		{
			if (Session::token() != $this->input['_token'])
			{
				throw new Illuminate\Session\TokenMismatchException;
			}

			if ($this->installer->deleteFilesRecursively(app_path() . '/views/installation'))
			{
				if ($this->installer->deleteFilesRecursively(app_path() . '/installation'))
				{
					return Redirect::route('admin.login');
				}
				return 'Oops! We managed to remove the "app/views/installation" directoy but were unable to remove the directory "app/installation" and its sub directories and files. You may need to remove it manually.';
			}
			else
			{
				$this->system->messages->setMessages(array(
					'error' => array(
						'Oops! We were unable to remove the directory "app/views/installation" and its sub directories and files. You may need to remove it manually.'
						)
					));
			}
		}
		$messages = $this->system->messages->getMessages();
		return View::make('installation.remove', compact('messages'));
	}
}