<?php
namespace Monal\API\Facades;

use Illuminate\Support\Facades\Facade;

class Packages extends Facade
{
	/**
	 * Get the registered name of the component.
	 *
	 * @return	String
	 */
	protected static function getFacadeAccessor() { return 'apipackages'; }
}