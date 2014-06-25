<?php
namespace Monal;
/**
 * Monal.
 *
 * This is the base system class which acts as a hub for connecting
 * the different system APIs together, and for processing user
 * authentication.
 *
 * @author  Arran Jacques
 */

class Monal
{
    /**
     * The system's messages.
     *
     * @var     Illuminate\Support\MessageBag
     */
    public $messages;

    /**
     * The system's App API.
     *
     * @var     Monal\Core\App
     */
    public $app;

    /**
     * The system's dashboard API.
     *
     * @var     Monal\Core\Dashboard
     */
    public $dashboard;

    /**
     * The system's permissions API.
     *
     * @var     Monal\Core\Permissions
     */
    public $permissions;

    /**
     * The system's packages API.
     *
     * @var     Monal\Core\Packages
     */
    public $packages;

    /**
     * The system's routes API.
     *
     * @var     Monal\Core\Routes
     */
    public $routes;

    /**
     * The system's current user.
     *
     * @var     Monal\Models\SystemUser
     */
    public $user;

    /**
     * Constructor.
     *
     * @return  Void
     */
    public function __construct()
    {
        $this->messages = \App::make('Illuminate\Support\MessageBag');
        $this->app = \App::make('Monal\Core\App');
        $this->dashboard = \App::make('Monal\Core\Dashboard');
        $this->permissions = \App::make('Monal\Core\Permissions');
        $this->packages = \App::make('Monal\Core\Packages');
        $this->routes = \App::make('Monal\Core\Routes');
    }

    /**
     * Create a new authentication request.
     *
     * @return  Monal\Core\AuthenticationRequest
     */
    public function newAuthRequest()
    {
        $this->revokeAuth();
        return \App::make('Monal\Models\AuthenticationRequest');
    }

    /**
     * Check if the current user has already been authenticated.
     *
     * @param   Boolean
     * @return  Boolean
     */
    public function attemptAuthFromSession($is_admin = false)
    {
        $user = (\Auth::check()) ? \Auth::user() : false;
        if ($user) {
            if ($user->active) {
                if ($is_admin) {
                    if ($user->GroupDetails->id != 1 AND !$user->GroupDetails->groupPermissions->admin) {
                        $this->user = new \Monal\Models\SystemUser();
                        return false;
                    }
                }
                $this->user = new \Monal\Models\SystemUser($user->toArray());
                return true;
            }
            $this->revokeAuth();
        }
        $this->user = new \Monal\Models\SystemUser();
        return false;
    }

    /**
     * Revoke the current user’s authentication.
     *
     * @return  Void
     */
    public function revokeAuth()
    {
        \Auth::logout();
    }
}