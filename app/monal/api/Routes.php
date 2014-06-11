<?php
namespace Monal\API;
/**
 * Routes API.
 *
 * This providers a static interface to the systems Routes API.
 *
 * @author  Arran Jacques
 */

use Monal\API;

class Routes extends API
{
    /**
     * Add a new admin route.
     *
     * @param   String
     * @param   String
     * @param   String
     * @param   String
     * @return  Void
     */
    public static function addAdminRoute($type, $url, $name, $controller)
    {
        self::systemInstance()->routes->addAdminRoute($type, $url, $name, $controller);
    }

    /**
     * Add a new closure to call for all requests to non-admin routes.
     *
     * @param   Closure
     * @return  Void
     */
    public static function addFrontendRouteClosure($closure)
    {
        self::systemInstance()->routes->addFrontendRouteClosure($closure);
    }
}