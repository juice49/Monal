<?php
/**
 * Installation Controller.
 *
 * @author  Arran Jacques
 */

use Monal\Monal;

class InstallationController extends BaseController
{
    /**
     * Installer Library.
     *
     * @var     Installer
     */
    protected $installer;

    /**
     * Constructor.
     *
     * @param   Monal\GatewayInterface
     * @param   Installer
     * @return  Void
     */
    public function __construct(Monal $system, Installer $installer)
    {
        parent::__construct($system);
        $this->installer = $installer;
        View::share('system', $this->system);
    }

    /**
     * Control and display install database page.
     *
     * @return  Illuminate\View\View
     */
    public function database()
    {
        if ($this->input) {
            if (Session::token() != $this->input['_token']) {
                throw new Illuminate\Session\TokenMismatchException;
            }
            if ($this->installer->installDatabase($this->input, isset($this->input['create']))) {
                return Redirect::route('installation.user');
            }
            $this->system->messages->merge($this->installer->messages());
        }
        $database_management_systems = array(
            'mysql' => 'MySQL',
            );
        $messages = $this->system->messages;
        return View::make('installation.database', compact('messages', 'database_management_systems'));
    }

    /**
     * Control and display create user page.
     *
     * @return  Illuminate\View\View
     */
    public function user()
    {
        if ($this->input)
        {
            if (Session::token() != $this->input['_token']) {
                throw new Illuminate\Session\TokenMismatchException;
            }
            if ($this->installer->createUser($this->input)) {
                return Redirect::route('installation.remove');
            }
            $this->system->messages->merge($this->installer->messages());
        }
        $messages = $this->system->messages;
        return View::make('installation.user', compact('messages'));
    }

    /**
     * Control and display remove installation files page.
     *
     * @return  Illuminate\View\View
     */
    public function remove()
    {
        if (isset($this->input['remove']))
        {
            if (Session::token() != $this->input['_token']) {
                throw new Illuminate\Session\TokenMismatchException;
            }
            if ($this->installer->deleteInstallationFiles()) {
                return Redirect::route('admin.login');
            }
            $this->system->messages->merge($this->installer->messages());
        }
        $messages = $this->system->messages;
        return View::make('installation.remove', compact('messages'));
    }
}