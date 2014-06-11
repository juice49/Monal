<?php
/**
 * Packages Controller.
 *
 * This is the controller for requests to the system's packages
 * dashboards.
 *
 * @author  Arran Jacques
 */

use Monal\GatewayInterface;

class PackagesController extends AdminController
{
	/**
	 * Process requests to the packages admin dashboard and output a
	 * response.
	 *
	 * @return  Illuminate\View\View / Illuminate\Http\RedirectResponse
	 */
	public function packages()
	{
		if (isset($this->input['package'])){
			if (Monal\API\Packages::install($this->input['package'])) {
				FlashMessages::flash('success', 'You successfully installed the package "' . $this->input['package'] . '"');
			} else {
				FlashMessages::flash('error', 'There was an error installing the package "' . $this->input['package'] . '"');
			}
			return Redirect::route('admin.packages');
		}
		$installed_packages = Monal\API\Packages::installedPackages();
		$uninstalled_packages = Monal\API\Packages::uninstalledPackages();
		$messages = $this->system->messages->merge(FlashMessages::all());
		return \View::make('admin.packages', compact('messages', 'installed_packages', 'uninstalled_packages'));
	}
}