<?php	
define('STR_ERROR_LOCATION_VALIDATE','Validation error');
define('STR_ERROR_LOCATION_NOT_FOUND','Location not found');
define('STR_ERROR_LOCATION_LOGIN','Login error');
define('STR_ERROR_LOCATION_EXIST','Location already exist');
define('STR_ERROR_STATE_EXIST', 'State already exist');
define('STR_ERROR_STATE_NOT_FOUND','State not found');
class DbLocationRepository extends Exception implements LocationRepository{
	protected $location_select_array = ['id','location','zipcode'];
	public function __construct($message = '',$error_code = null){

	}
	/**
	 * get all location
	 */
	public function AllLocation($orderBy = 'ASC'){
		return Location::select($this->location_select_array)->orderBy('location',$orderBy)->get();
	}
	/**
	 * Insert new location, if $type == 1 => return new location id
	 */
	public function InsertLocation($location,$zipcode = '',$type = null){
		$vali  = [
			'location'=>$location,
			'zipcode' => $zipcode,
		];
		$rules = [
			'location' => ['required','max:20'],
			'zipcode'  => ['regex:/^[0-9]+$/','max:7'],
		];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_LOCATION_VALIDATE, 1);
		elseif(Location::where('location','=',$location)->count() > 0)
			throw new Exception(STR_ERROR_LOCATION_EXIST, 2);
		else
			$location = [
				'location' => $location,
				'zipcode'  => $zipcode,
			];
			if($type == 1)
				return Location::insertGetId($location);
			else
				Location::insert($location);
			
	}
	/**
	 * Delete location
	 */
	public function DeleteLocation($location_id){
		$vali  = ['location_id' => $location_id];
		$rules = ['location_id' => ['required','regex:/^[0-9]+$/']];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_LOCATION_VALIDATE, 1);
		elseif(!Auth::check())
			throw new Exception(STR_ERROR_LOCATION_LOGIN, 2);
		else
			$location = Location::find($location_id);
			if(empty($location))
				throw new Exception(STR_ERROR_LOCATION_NOT_FOUND, 3);
			else
				$location->delete();
	}
	/**
	 * get all state in location
	 */
	public function LocationState($role_id = null,$orderBy = 'ASC'){
		if($role_id && $role_id == 3){
			$user = Auth::user();
			$locations = $user->Location;
		}else{
			$locations = Location::orderBy('location',$orderBy)->get();
		}
		foreach($locations as $location){
			$location->State;
		}
		return $locations;
	}
	/**
	 * Insert state
	 */
	public function InsertState($location_id,$state,$zipcode = ''){
		$vali = [
			'location_id' => $location_id,
			'state'       => $state,
			'zipcode'     => $zipcode,
		];
		$rules = [
			'location_id' => ['required','regex:/^[0-9]+$/'],
			'state' => ['max:50'],
			'zipcode' => ['max:7','regex:/^[0-9]+$/'],
		];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_LOCATION_VALIDATE, 1);
		elseif(State::where('location_id','=',$location_id)->where('state','=',$state)->count() > 0)
			throw new Exception(STR_ERROR_STATE_EXIST, 2);
		else
			$state = [
				'location_id' => $location_id,
				'state'       => $state,
			];
			$state_id = State::insertGetId($state);
			$state['id'] = $state_id;
			return $state;			
	}
	public function DeleteState($state_id){
		$vali  = ['state_id' => $state_id];
		$rules = ['state_id' => ['required','regex:/^[0-9]+$/']];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_LOCATION_VALIDATE, 1);
		elseif(!Auth::check())
			throw new Exception(STR_ERROR_LOCATION_LOGIN, 1);
		else
			$state = State::find($state_id);
			if(empty($state))
				throw new Exception(STR_ERROR_STATE_NOT_FOUND, 2);
			else
				$state->delete();		
	}
	/**
	 * Check Location
	 */
	public function CheckLocation($location){
		$count = Location::where('location','=',$location)->count();
		if($count > 0)
			return 'false';
		else
			return 'true';
	}
	/**
	 * Check Location
	 */
	public function CheckState($state,$location_id){
		$count = State::where('location_id','=',$location_id)->where('state','=',$state)->count();
		if($count > 0)
			return 'false';
		else
			return 'true';
	}
}
?>