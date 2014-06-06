<?php
/**
 * Packages Controller.
 *
 * Controller for HTTP/S requests for system's package pages.
 *
 * @author	Arran Jacques
 */

use Monal\GatewayInterface;

class PackagesController extends AdminController
{
	/**
	 * Controller for HTTP/S requests for the systems Packages page.
	 * Mediates the requests and outputs a response.
	 *
	 * @return	Illuminate\View\View / Illuminate\Http\RedirectResponse
	 */
	public function packages()
	{
		if (isset($this->input['package'])){
			if (Packages::install($this->input['package'])) {
				$this->system->messages->add(array(
					'success' => array(
						'You successfully installed the package "' . $this->input['package'] . '"',
					),
				))->flash();
			} else {
				$this->system->messages->add(array(
					'error' => array(
						'There was an error installing the package "' . $this->input['package'] . '"',
					),
				))->flash();
			}
			return Redirect::route('admin.packages');
		}
		$uninstalled_packages = Packages::unistalledPackages();
		$messages = $this->system->messages->get();
		return \View::make('admin.packages', compact('messages', 'uninstalled_packages'));
	}
}