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
}
