<?php
namespace Monal\Repositories\Facades;

use Illuminate\Support\Facades\Facade;

class PackagesRepository extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return  String
     */
    protected static function getFacadeAccessor() { return 'PackagesRepository'; }
}