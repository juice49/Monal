<?php
namespace Monal;

interface MonalPackageServiceProvider
{
	/**
	 * Return the package's namespace.
	 *
	 * @return	String
	 */
	public function packageNamespace();

	/**
	 * Return the package's details.
	 *
	 * @return	Array
	 */
	public function packageDetails();

	/**
	 * Install the package.
	 *
	 * @return	Boolean
	 */
	public function install();
}