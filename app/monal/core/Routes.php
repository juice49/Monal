<?php
namespace Monal\Core;
/**
 * Routes.
 *
 * This is Monal’s routes API, which provides methods for handling
 * request made to the system.
 *
 * @author  Arran Jacques
 */

class Routes
{
    /**
     * An array of closures to try for requests to non-admin routes.
     *
     * @var     Array
     */
    public $frontend_closures = array();

    /**
     * Return all frontend route closures registered with the system.
     *
     * @return  Array
     */
    public function getFrontendRouteClosures()
    {
        return $this->frontend_closures;
    }

    /**
     * Add a new admin route.
     *
     * @param   String
     * @param   String
     * @param   String
     * @param   String
     * @return  Void
     */
    public function addAdminRoute($type, $url, $name, $controller)
    {
        $route = \Config::get('admin.slug') . '/' .$url;
        switch (strtolower($type)) {
            case 'get':
                \Route::get($route, array('as' => $name, 'uses' => $controller));
                break;
            case 'post':
                \Route::post($route, array('as' => $name, 'uses' => $controller));
                break;
            case 'any':
                \Route::any($route, array('as' => $name, 'uses' => $controller));
                break;
        }
    }

    /**
     * Add a new closure to call for all requests to non-admin routes.
     *
     * @param   Closure
     * @return  Void
     */
    public function addFrontendRouteClosure($closure)
    {
        array_push($this->frontend_closures, $closure);
    }
}