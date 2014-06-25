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
     * Return the template to use for 404 errors.
     *
     * @return  String
     */
    public static function missingTemplate()
    {
        return self::systemInstance()->app->missingTemplate();
    }

    /**
     * Set the template to use for 404 errors.
     *
     * @param   String
     * @return  Void
     */
    public static function setMissingTemplate($template)
    {
        return self::systemInstance()->app->setMissingTemplate($template);
    }
}