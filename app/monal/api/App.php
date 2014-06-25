<?php
namespace Monal\API;
/**
 * App API.
 *
 * Static end points for directly accessing Monal’s App methods and
 * properties.
 *
 * @author  Arran Jacques
 */

use Monal\API;

class App extends API
{
    /**
     * Return the template to use for general errors.
     *
     * @return  String
     */
    public static function errorTemplate()
    {
        return self::systemInstance()->app->errorTemplate();
    }

    /**
     * Set the template to use for general errors.
     *
     * @param   String
     * @return  Void
     */
    public static function setErrorTemplate($template)
    {
        return self::systemInstance()->app->setErrorTemplate($template);
    }

    /**
     * Return the template to use for 403 errors.
     *
     * @return  String
     */
    public static function error403Template()
    {
        return self::systemInstance()->app->error403Template();
    }

    /**
     * Set the template to use for 403 errors.
     *
     * @param   String
     * @return  Void
     */
    public static function setError403Template($template)
    {
        return self::systemInstance()->app->setError403Template($template);
    }

    /**
     * Return the template to use for 404 errors.
     *
     * @return  String
     */
    public static function error404Template()
    {
        return self::systemInstance()->app->error404Template();
    }

    /**
     * Set the template to use for 404 errors.
     *
     * @param   String
     * @return  Void
     */
    public static function setError404Template($template)
    {
        return self::systemInstance()->app->setError404Template($template);
    }

    /**
     * Return the template to use for 500 errors.
     *
     * @return  String
     */
    public static function error500Template()
    {
        return self::systemInstance()->app->error500Template();
    }

    /**
     * Set the template to use for 500 errors.
     *
     * @param   String
     * @return  Void
     */
    public static function setError500Template($template)
    {
        return self::systemInstance()->app->setError500Template($template);
    }
}