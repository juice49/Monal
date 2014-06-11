<?php
namespace Monal\Libraries\Facades;

use Illuminate\Support\Facades\Facade;

class FlashMessages extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return  String
     */
    protected static function getFacadeAccessor() { return 'FlashMessages'; }
}