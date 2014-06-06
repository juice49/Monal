<?php
namespace Monal\Repositories;
/**
 * Package Repository.
 *
 * A repository for storing package details. The class defines
 * methods for reading, writing, updating and removing packages to
 * the repository.
 *
 * @author	Arran Jacques
 */

use Monal\Models\Package;

class PackagesRepository
{
	/**
	 * The database table the repository uses.
	 *
	 * @var		String
	 */
	protected $table = 'packages';

	/**
	 * The repository's messages.
	 *
	 * @var		 Monal\Core\Contracts\MessagesInterface
	 */
	protected $messages;

	/**
	 * Constructor.
	 *
	 * @return	Void
	 */
	public function __construct()
	{
		$this->messages = \App::make('Monal\Core\Contracts\MessagesInterface');
	}

	/**
	 * Return the repository's messages.
	 *
	 * @return	Illuminate\Support\MessageBag
	 */
	public function messages()
	{
		return $this->messages->get();
	}

	/**
	 * Return a new Package model.
	 *
	 * @return	Monal\Models\Package
	 */
	public function newModel()
	{
		return \App::make('Monal\Models\Package');
	}

	/**
	 * Check a Package model validates for storage.
	 *
	 * @param	Monal\Models\Package
	 * @return	Boolean
	 */
	public function validatesForStorage(Package $package)
	{
		$unique_exception = ($package->ID()) ? ',' . $package->ID() : null;
		$validation_rules = array(
			'name' => 'required|max:255|unique:packages,name' . $unique_exception,
		);
		$validation_messages = array(
			'name.required' => 'You need to give this package a Name.',
			'name.max' => 'The Name for this package is to long. It must be no more than 255 characters long.',
			'name.unique' => 'There is already a package using this Name. Please choose a different one.',
		);
		if ($package->validates($validation_rules, $validation_messages)) {
			return true;
		} else {
			$this->messages->add($package->messages()->toArray());
			return false;
		}
	}

	/**
	 * Encode a Package model so it is ready to be stored in the
	 * repository.
	 *
	 * @param	Monal\Models\Package
	 * @return	Array
	 */
	protected function encodeForStorage(Package $package)
	{
		return array(
			'name' => $package->name(),
		);
	}

	/**
	 * Decode a Package repository entry into its model class.
	 *
	 * @param	stdClass
	 * @return	Monal\Models\Package
	 */
	protected function decodeFromStorage($result)
	{
		$package = $this->newModel();
		$package->setID($result->id);
		$package->setName($result->name);
		return $package;
	}

	/**
	 * Retrieve an instance/s from the repository.
	 *
	 * @param	Integer
	 * @return	Illuminate\Database\Eloquent\Collection / Monal\Models\Package
	 */
	public function retrieve($key = null)
	{
		if (!$key) {
			$packages = \App::make('Illuminate\Database\Eloquent\Collection');
			foreach (\DB::table($this->table)->select('*')->get() as $result) {
				$packages->add($this->decodeFromStorage($result));
			}
			return $packages;
		} else {
			if ($result = \DB::table($this->table)->where('id', '=', $key)->first()) {
				$package = $this->decodeFromStorage($result);
				return $package;
			}
		}
		return false;
	}

	/**
	 * Retrieve an instance from the repository using it's name.
	 *
	 * @param	String
	 * @return	Monal\Models\Package
	 */
	public function retrieveByName($name)
	{
		if ($result = \DB::table($this->table)->where('name', '=', $name)->first()) {
			$package = $this->decodeFromStorage($result);
			return $package;
		}
		return false;
	}

	/**
	 * Write a Package model to the repository.
	 *
	 * @param	Monal\Models\Package
	 * @return	Boolean
	 */
	public function write(Package $package)
	{
		if ($this->validatesForStorage($package)) {
			$encoded = $this->encodeForStorage($package);
			if ($package->ID()) {
				$encoded['updated_at'] = date('Y-m-d H:i:s');
				\DB::table($this->table)->where('id', '=', $package->ID())->update($encoded);
				return true;
			} else {
				$encoded['created_at'] = date('Y-m-d H:i:s');
				$encoded['updated_at'] = date('Y-m-d H:i:s');
				\DB::table($this->table)->insert($encoded);
				return true;
			}
		}
		return false;
	}
}