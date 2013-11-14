<?php
/**
 * Modules Controller
 *
 * Controller for Modules Module's CMS admin pages
 *
 * @author Arran Jacques
 */

use App\Modules\Users\Contracts\UserAuthInterface;
use App\Modules\Messages\Contracts\MessagesInterface;
use App\Modules\Modules\Contracts\ModulesManagerInterface;

class ModulesController extends AdminController {

	public function __construct(UserAuthInterface $auth, MessagesInterface $message, ModulesManagerInterface $modules)
	{
		parent::__construct($auth, $message, $modules);
	}

	/**
	 * Controls and displays modules page
	 *
	 * @return	Illuminate\View\View
	 */
	public function modules()
	{
		if (!$this->user)
		{
			return Redirect::route('admin.login');
		}
		if (!$this->user->hasAccessPrivileges('modules'))
		{
			return Redirect::route('admin');
		}
		$modules = $this->modules->getInstalledModules();
		$messages = $this->message->getMessages();
		return View::make('modules::modules', compact('messages', 'modules'));
	}
}