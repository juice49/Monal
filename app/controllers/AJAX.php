<?php
/**
 * AJAX Controller
 *
 * Base AJAX controller for making AJAX requests to the CMS
 *
 * @author Arran Jacques
 */

class AJAXController extends BaseController {

	public function map()
	{
		$data = Input::all();

		if (isset($data['_use']))
		{
			$map = explode('@', $data['_use']);
			$class = (isset($data['_namespace'])) ? ($data['_namespace'] . '\\' . $map[0]) : $map[0];
			$load = new $class();
			unset(
					$data['_use'],
					$data['_namespace']
				);
			return $load->{$map[1]}($data);
		}
		return 'error';
	}
}