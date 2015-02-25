<?php
class ApiController extends Controller{
	protected $DealApi;
	protected $users;
	protected $location;
	protected $PromocodeApi;
	public function __construct(DealApiRepository $DealApi, UserRepository $users, LocationRepository $location,PromocodeApiRepository $PromocodeApi){
		/**
		 * Use DealApiRepository [dir repositories/DealApiRepository.php]
		 */
		$this->DealApi = $DealApi;
		/**
		 * Use UserRepository [dir night-fury/admin/repositories/UserRepository.php]
		 */
		$this->users = $users;
		/**
		 * Use LocationRepository [dir night-fury/admin/repositories/LocationRepository.php]
		 */
		$this->location = $location;

		$this->PromocodeApi = $PromocodeApi;
	}
	public function getIndex(){
		return 'Hello, API v1 :D';
	}
	public function getTest(){
		$users = $this->users->all();
		return App::make('BaseController')->ReturnData($users);
	}
	/**
	 * Login
	 */
	public function postLogin(){
		try {
			extract(Input::only('email','password'));
			$user = $this->users->ApiLogin($email, $password);
            return App::make('BaseController')->ReturnData($user);
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);
		}
	}
	/**
	 * Register
	 */
	public function postRegister(){
		try {
			extract(Input::all());
			$user = $this->users->ApiRegister($username, $email, $password);
            return App::make('BaseController')->ReturnData($user);
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);
		}
	}
	/**
	 * All deals - GET /api/v1/deals?page={$page}
	 */
	public function getDeals($id = null){
		$page = App::make('BaseController')->Page('page',DEALS_PER_PAGE);
		if($id){
			$deals = [];
			$deals[] = Deal::find($id);
		}else{
			$deals = $this->DealApi->All($page->skip,$page->take);
		}
		foreach ($deals as $deal) {
			$deal->image = asset($deal->image);
			$deal->DealLocation;
			$deal->Location;
			$deal->State;
			$deal->Category;
			$deal->DealRate;
		}
		return App::make('BaseController')->ReturnData($deals);
	}

	
	/**
	 * Rate a Deal
	 */
	public function postRateDeal(){
		try {
			extract(Input::all());
			$this->users->CheckUserRememberToken($user_id, $remember_token);
			$this->DealApi->RateDeal($user_id, $deal_id, $number_star);
			return App::make('BaseController')->ReturnSuccess();
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);
		}
	}
	/**
	 * Check Rated
	 */
	public function getCheckRated($user_id,$deal_id){
		try {
			$data = $this->users->CheckRated($user_id,$deal_id);
			return App::make('BaseController')->ReturnData($data);
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);
		}
	}
	/**
	 * Deal Available GET /api/v1/deals-available
	 */
	public function getDealsAvailable(){
		try {
			$page = App::make('BaseController')->Page('page');
			$deals = $this->DealApi->DealAvailable($page->skip,$page->take);
			/**
			 * Format Deal Data
			 */
			$deals = App::make('BaseController')->FormatDealData($deals);
			/**
			 * Return
			 */
			return App::make('BaseController')->ReturnData($deals);
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);
		}
	}
	/**
	 * Get /api/v1/location-state
	 */
	public function getLocationState(){
		$locations = $this->location->AllLocation();
		foreach($locations as $location){
			$location->State;
		}
		return App::make('BaseController')->ReturnData($locations);
	}
	/**
	 * GET /api/v1/location
	 */
	public function getLocation(){
		$locations = $this->location->AllLocation();
		return App::make('BaseController')->ReturnData($locations);
	}
	/**
	 * Search Deals POST /api/v1/search
	 */
	public function postSearch(){
		try {
			extract(Input::all());
				/**
				 * if $type == 1 => Search With Post Code 
				 */
			if($type == 1){ 
				$deals = $this->DealApi->SearchWithPostCode($postcode,$skip,$take);
				/**
				 * Search With GeoLocation
				 */
			}elseif($type == 2){
				$deals = $this->DealApi->NearMe($distance, $lat, $lng, $skip, $take);
				/**
				 * Search With Location id
				 */
			}elseif($type == 3){
				$deals = $this->DealApi->SearchWithLocationId($location_id, $skip, $take);
				/**
				 * Search With State id
				 */
			}elseif($type == 4){
				$deals = $this->DealApi->SearchWithStateId($state_id, $skip, $take);
			}else{
				return false;
			}
			/**
			 * Format Deal Data
			 */
			$deals = App::make('BaseController')->FormatDealData($deals);
			/**
			 * Return
			 */
			return App::make('BaseController')->ReturnData($deals);
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);
		}
	}
	/**
	 * Categories GET /api/v1/categories
	 */
	public function getCategories($id = null){
		if($id){
			$vali  = ['id' => $id];
			$rules = ['id' => ['required','regex:/^[0-9]+$/']];
			if(Validator::make($vali,$rules)->fails())
				throw new Exception(STR_ERROR_VALIDATE, 1);
			else
				$page = App::make('BaseController')->Page('page');
				$category = Categories::find($id);
				$deals = $category->Deal()->skip($page->skip)->take($page->take)->get();
				$category->deal = $deals;
				return App::make('BaseController')->ReturnData($category);
		}else{
			$categories = Categories::get();
			return App::make('BaseController')->ReturnData($categories);
		}
	}
	/*
	* save deal
	*/
	public function postSaveDeal()
	{
		try {
			extract(Input::only('user_id','remember_token','deal_id'));
			$this->DealApi->SaveDeal($user_id,$remember_token,$deal_id);
			return App::make('BaseController')->ReturnSuccess();
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);
		}
	}
	/*
	* get list deal saved
	*/
	public function postListSaved()
	{
		try {
			extract(Input::only('user_id','remember_token'));
			$list_saved = $this->DealApi->getListSaved($user_id,$remember_token);
			return $list_saved;
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);
		}
	}
	public function postCheckSaveDeal()
	{
		try {
			extract(Input::only('user_id','remember_token','deal_id'));
			$check = $this->DealApi->CheckSaveDeal($user_id,$remember_token,$deal_id);
			return ['status' => STR_STATUS_SUCCESS,'response' => $check];
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);
		}
	}
	public function postRemoveSaveDeal()
	{
		try {
			extract(Input::only('user_id','remember_token','deal_id'));
			$this->DealApi->RemoveSaveDeal($user_id,$remember_token,$deal_id);
			return App::make('BaseController')->ReturnSuccess();
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);
		}
	}
	public function postUsePromocode()
	{
		try {
			extract(Input::only('user_id','remember_token','promocode'));
			$this->PromocodeApi->UsePromocode($user_id,$remember_token,$promocode);
			return App::make('BaseController')->ReturnSuccess();
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);
		}
	}
	public function postBuyDeal()
	{
		try {
			extract(Input::only('user_id','remember_token','deal_id'));
			$this->DealApi->BuyDeal($user_id,$remember_token,$deal_id);
			return App::make('BaseController')->ReturnSuccess();
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);
		}
	}
}
?>