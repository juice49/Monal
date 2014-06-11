<?php
namespace Monal;
/**
 * Monal API.
 *
 * This is the base API class, which provides a static interface to
 * the system’s various APIs.
 *
 * @author  Arran Jacques
 */

class API
{
    /**
     * Return the current system instace.
     *
     * @return  Monal\Monal
     */
    public static function systemInstance()
    {
        return \App::make('Monal\Monal');
    }
}