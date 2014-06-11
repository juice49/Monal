<?php
namespace Monal\API;
/**
 * Dashboad API.
 *
 * This providers a static interface to the systems Dashboard API.
 *
 * @author  Arran Jacques
 */

use Monal\API;

class Dashboard extends API
{
    /**
     * Return the collection of CSS files to load with the dashboard.
     *
     * @return  Array 
     */
    public function css()
    {
        return self::systemInstance()->dashboard->css();
    }

    /**
     * Return the collection of JS files to load with the dashboard.
     *
     * @return  Array 
     */
    public function scripts()
    {
        return self::systemInstance()->dashboard->scripts();
    }

    /**
     * Return the dashboard's menu options.
     *
     * @return  Array 
     */
    public function menu()
    {
        return self::systemInstance()->dashboard->menu();
    }

    /**
     * Add a CSS file to be loaded with the dashboard.
     *
     * @param   String
     * @return  Void
     */
    public function addCSS($uri)
    {
        self::systemInstance()->dashboard->addCSS($uri);
    }

    /**
     * Add a JS file to be loaded with the dashboard.
     *
     * @param   String
     * @return  Void
     */
    public function addScript($uri)
    {
        self::systemInstance()->dashboard->addScript($uri);
    }

    /**
     * Add a menu option to the dashboard.
     *
     * @param   String
     * @param   String
     * @param   String
     * @param   String
     * @return  Void
     */
    public static function addMenuOption($category, $title, $route, $permissions = null)
    {
        self::systemInstance()->dashboard->addMenuOption($category, $title, $route, $permissions);
    }
}