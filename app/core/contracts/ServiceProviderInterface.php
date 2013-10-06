<?php namespace App\Core\Contracts;

interface ServiceProviderInterface {

	public function boot();

	public function register();
}