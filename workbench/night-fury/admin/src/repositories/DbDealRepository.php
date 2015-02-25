<?php
class DbDealRepository extends Exception implements DealRepository{
	protected $auth;
	public function __construct($message = '',$error_code = null){
		$this->auth = Auth::user();
	}
	public function All($role = null){
		if(!$role || $role == 1 || $role == 2){
			$deals =  Deal::get();
		}elseif($role == 3){
			$deals = $this->auth->Deal;
		}
		foreach ($deals as $deal) {
			$deal->Location;
			$deal->DealLocation;
			$deal->State;
			$deal->Category;
			$deal->User;
			$deal->image = asset($deal->image);
		}
		return $deals;

	}
	/**
	 * Remove Deal
	 */
	public function RemoveDeal($id){
		$vali  = ['id' => $id];
		$rules = ['id' => ['required','regex:/^[0-9]+$/']];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_VALIDATE, 1);
		else
			$deal = Deal::find($id);
			if(empty($deal))
				throw new Exception(STR_ERROR_DEAL_NOT_FOUND, 6);
			else
				$deal->delete();
				return true;
			
	}

	/*
	* Save Deal
	*/
	public function SaveDeal($deal,$image,$location,$state, $category, $deal_location,$deal_id = NEW_DEAL,$time_sensitive,$time_sensitive_header)
	{
		if($deal_id == NEW_DEAL){
			$db_deal = new Deal();
			$db_deal_location = new DealLocation();
		}else{
			$db_deal = Deal::find($deal_id);
			$db_deal_location = $db_deal->DealLocation;
		}
		$db_deal->user_id     = $this->auth->id;
		$db_deal->location_id = $location['id'];
		$db_deal->state_id    = $state['id'];
		$db_deal->category_id = $category['id'];
		$db_deal->image       = $image;
		$deal['start_date']   = App::make('BaseController')->ConvertTime($deal['start_date'],VIEW_TO_DATABASE);
		$deal['end_date']     = App::make('BaseController')->ConvertTime($deal['end_date'],VIEW_TO_DATABASE);
		foreach($deal as $key => $value){
			$db_deal->$key = $value;
		}
		$db_deal->time_sensitive        = $time_sensitive;
		$db_deal->time_sensitive_header = $time_sensitive_header;
		$db_deal->save();
		/*
		* Save DealLocation
		*/
		$db_deal_location->deal_id = $db_deal->id;
		$db_deal_location->lat = $deal_location['lat'];
		$db_deal_location->lng = $deal_location['lng'];
		$db_deal_location->save();
	}
}
?>