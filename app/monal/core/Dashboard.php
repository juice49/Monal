<?php
namespace Monal\Core;
/**
 * Dashboard.
 *
 * This is Monal’s dashboard API to allow interaction with the
 * system’s admin dashboard.
 *
 * @author  Arran Jacques
 */

class Dashboard
{
    /**
     * An array of menu options for the dashboards control panel.
     *
     * @var     Array
     */
    protected $menu = array();

    /**
     * An array of CSS files to load for the dashboard.
     *
     * @var     Array
     */
    protected $css = array();

    /**
     * An array of JS files to load for the dashboard.
     *
     * @var     Array
     */
    protected $scripts = array();

    /**
     * Return the collection of CSS files to load with the dashboard.
     *
     * @return  Array 
     */
    public function css()
    {
        return $this->css;
    }

    /**
     * Return the collection of JS files to load with the dashboard.
     *
     * @return  Array 
     */
    public function scripts()
    {
        return $this->scripts;
    }

    /**
     * Return the dashboard's menu options.
     *
     * @return  Array 
     */
    public function menu()
    {
        return $this->menu;
    }

    /**
     * Add a CSS file to be loaded with the dashboard.
     *
     * @param   String
     * @return  Void
     */
    public function addCSS($uri)
    {
        array_push($this->css, \URL::to($uri));
    }

    /**
     * Add a JS file to be loaded with the dashboard.
     *
     * @param   String
     * @return  Void
     */
    public function addScript($uri)
    {
        array_push($this->scripts, \URL::to($uri));
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
    public function addMenuOption($category, $title, $route, $permissions = null)
    {
        if (!isset($this->menu[$category])) {
            $this->menu[$category] = array();
        }
        $this->menu[$category][$title] = array(
            'route' => $route,
            'permissions' => $permissions,
        );
    }
}