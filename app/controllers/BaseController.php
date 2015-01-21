<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
	public function Success($data = null)
	{
		if($data)
			return ['status' => STR_STATUS_SUCCESS,'data' => $data];
		else 
			return ['status' => STR_STATUS_SUCCESS];
	}
	public function Error($e)
	{
		if($e)
			return ['status' => STR_STATUS_ERROR,'message' => $e->getMessage(), 'error_code' => $e->getCode()];
		else
			return ['status' => STR_STATUS_ERROR];
	}
	function calcDistance($lat1,$lng1, $lat2, $lng2){
		//RAD
		$b1 = ($lat1/180)*M_PI;
		$b2 = ($lat2/180)*M_PI;
		$l1 = ($lng1/180)*M_PI;
		$l2 = ($lng2/180)*M_PI;
		//equatorial radius
		$r = 3986; //r in mile
		// Formel
		$e = acos( sin($b1)*sin($b2) + cos($b1)*cos($b2)*cos($l2-$l1) );
		return round($r*$e, 4);
	}
}
