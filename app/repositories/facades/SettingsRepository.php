<?php
namespace Monal\Repositories\Facades;

use Illuminate\Support\Facades\Facade;

class SettingsRepository extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return  String
     */
    protected static function getFacadeAccessor() { return 'SettingsRepository'; }
}