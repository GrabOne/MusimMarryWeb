<?php
class DbDealApiRepository extends \Exception implements DealApiRepository{
	public function __construct($message = '',$error_code = null){

	}
	public function All($skip, $take,$orderBy = 'DESC'){
		return Deal::skip($skip)->take($take)->orderBy('id',$orderBy)->get();
	}
	/**
	 * Rate a Deal
	 */
	public function RateDeal($user_id, $deal_id, $number_star){
		$vali  = [
			'deal_id'     => $deal_id, 
			'number_star' => $number_star
		];
		$rules = [
			'deal_id'     => ['required','regex:/^[0-9]+$/'],
			'number_star' => ['required','regex:/^[0-9]+$/'],
		];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_VALIDATE, 1);
		elseif($number_star > NUMBER_RATE_START)
			throw new Exception(STR_ERROR_NUMBER_STAR, 7);
		else
			$rated = UserRate::where('user_id','=',$user_id)
							 ->where('deal_id','=',$deal_id)
							 ->count();
			if($rated > 0)
				throw new Exception(STR_ERROR_RATED, 10);
			else
				$deal = Deal::find($deal_id);
				if(empty($deal))
					throw new Exception(STR_ERROR_DEAL_NOT_FOUND, 6);
				else
					UserRate::insert(['user_id' => $user_id, 'deal_id' => $deal_id , 'number_star' => $number_star]);
					$rate_count = DealRate::where('deal_id','=',$deal_id)->count();
					if($rate_count == 0){
						$rate = [
							'deal_id'      => $deal_id,
							'total_rate'   => 1,
							'number_star' => $number_star,
						];
						DealRate::insert($rate);
					}else{
						$rate = DealRate::where('deal_id','=',$deal_id)->first();
						$rate->total_rate  += 1;
						$rate->number_star += $number_star;
						$rate->save();
					}
				
	}
	/**
	 * Deal Available
	 */
	public static function DealAvailable($skip,$take,$orderBy = 'DESC'){
		$str_time = date('Y-m-d');
		$deals = Deal::where('start_date','<=',$str_time)
		     		 ->where('end_date','>=',$str_time)
		     		 ->skip($skip)
		     		 ->take($take)
		     		 ->orderBy('id',$orderBy)
		     		 ->get();
		return $deals;
	}
	/**
	 * Search Deals With Post Code
	 */
	public function SearchWithPostCode($postcode,$skip,$take){
		return Deal::where('postcode','=',$postcode)
					 ->skip($skip)
					 ->take($take)
					 ->get();
	}
	/**
	 * Caculate distance
	 */
	public function calcDistance($lat1,$lng1, $lat2, $lng2){
		//RAD
		$b1 = ($lat1/180)*M_PI;
		$b2 = ($lat2/180)*M_PI;
		$l1 = ($lng1/180)*M_PI;
		$l2 = ($lng2/180)*M_PI;
		//equatorial radius
		$r = 6371; //r in km
		// Formel
		$e = acos( sin($b1)*sin($b2) + cos($b1)*cos($b2)*cos($l2-$l1) );
		return round($r*$e, 4);
	}
	/**
	 * NearMe
	 */
	public function NearMe($distance, $lat, $lng,$skip,$take){
		$vali = [
			'distance' => $distance,
			'lat'      => $lat,
			'lng'      => $lng,
			'skip'     => $skip,
			'take'     => $take,
		];
		$rules = [
			'distance' => ['required','regex:/^[0-9\.]+$/'],
			'lat'      => ['required','regex:/^[0-9\.]+$/'],
			'lng'      => ['required','regex:/^[0-9\.]+$/'],
			'skip'     => ['required','regex:/^[0-9]+$/'],
			'take'     => ['required','regex:/^[0-9]+$/']
		];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_VALIDATE, 1);
		else
			$deal_locations = DealLocation::get();
			$deals = [];
			foreach($deal_locations as $deal_location){
				$dist = $this->calcDistance($lat, $lng, $deal_location->lat, $deal_location->lng);
				if($dist <= $distance){
					$deal = Deal::find($deal_location->deal_id);
					if(!empty($deal)){
						$deal->distance = ['distance' => $dist, 'unit' => 'km'];
						$deals[] = $deal;
					}
				}
			} 
			foreach ($deals as $key => &$deal) {
				if($key > 0){
					if($deals[$key -1]->distance['distance'] > $deal->distance['distance'] ){
						$tmp_deal       = $deals[$key -1];
						$deals[$key -1] = $deal;
						$deal           = $tmp_deal;
					}
				}
				foreach($deals as $k => &$value){
					if($k > 0){
						if($deals[$k-1]->distance['distance'] > $value->distance['distance']){
							$tmp_deal     = $deals[$k -1];
							$deals[$k -1] = $value;
							$value        = $tmp_deal;
						}
					}
				}
			}
			$deals = array_splice($deals, $skip, $take);
			return $deals;
	}
	/**
	 * Search With Location_id
	 */
	public function SearchWithLocationId($location_id, $skip, $take,$orderBy = 'DESC'){
		$vali = [
			'location_id' => $location_id,
			'skip'        => $skip,
			'take'        => $take, 
		];
		$rules = [
			'location_id' => ['required','regex:/^[0-9]+$/'],
			'skip'        => ['required','regex:/^[0-9]+$/'],
			'take'        => ['required', 'regex:/^[0-9]+$/'],
		];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_VALIDATE, 1);
		else
			return Deal::where('location_id','=',$location_id)
					   ->skip($skip)
					   ->take($take)
					   ->orderBy('id',$orderBy)
					   ->get();
			
	}
	/**
	 * Search With state_id
	 */
	public function SearchWithStateId($state_id, $skip, $take,$orderBy = 'DESC'){
		$vali = [
			'state_id' => $state_id,
			'skip'     => $skip,
			'take'     => $take, 
		];
		$rules = [
			'state_id' => ['required','regex:/^[0-9]+$/'],
			'skip'     => ['required','regex:/^[0-9]+$/'],
			'take'     => ['required', 'regex:/^[0-9]+$/'],
		];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_VALIDATE, 1);
		else
			return Deal::where('state_id','=',$state_id)
					   ->skip($skip)
					   ->take($take)
					   ->orderBy('id',$orderBy)
					   ->get();
			
	}
	/*
	* Save Deal
	*/
	public function SaveDeal($user_id,$remember_token,$deal_id)
	{
		$user = User::find($user_id);
		if(empty($user))
			throw new Exception(STR_ERROR_USER_NOT_FOUND, 8);
		elseif($user->remember_token != $remember_token)
			throw new Exception(STR_ERROR_REMEMBER_TOKEN, 9);
		else
			$deal = Deal::find($deal_id);
			if(empty($deal))
				throw new Exception(STR_ERROR_DEAL_NOT_FOUND, 6);
			else
				$check = SaveDeal::where('user_id','=',$user_id)->where('deal_id','=',$deal_id)->count();
				if($check > 0)
					throw new Exception(STR_ERROR_DEAL_ALREADY_SAVE, 12);
				else
					SaveDeal::insert(['user_id'=>$user_id,'deal_id'=>$deal_id]);
	}
	/*
	* get list deal saved
	*/
	public function getListSaved($user_id,$remember_token)
	{
		$user = User::find($user_id);
		if(empty($user))
			throw new Exception(STR_ERROR_USER_NOT_FOUND, 8);
		elseif($user->remember_token != $remember_token)
			throw new Exception(STR_ERROR_REMEMBER_TOKEN, 9);
		else
			return $user->DealSaved;
	}
	public function CheckSaveDeal($user_id,$remember_token,$deal_id)
	{
		$user = User::find($user_id);
		if(empty($user))
			throw new Exception(STR_ERROR_USER_NOT_FOUND, 8);
		elseif($user->remember_token != $remember_token)
			throw new Exception(STR_ERROR_REMEMBER_TOKEN, 9);
		else
			$deal = Deal::find($deal_id);
			if(empty($deal))
				throw new Exception(STR_ERROR_DEAL_NOT_FOUND, 6);
			else
				$check = SaveDeal::where('user_id','=',$user_id)->where('deal_id','=',$deal_id)->count();
				if($check > 0)
					return true;
				else
					return false;
				
	}
	/*
	* remove save deal
	*/
	public function RemoveSaveDeal($user_id,$remember_token,$deal_id)
	{
		$user = User::find($user_id);
		if(empty($user))
			throw new Exception(STR_ERROR_USER_NOT_FOUND, 8);
		elseif($user->remember_token != $remember_token)
			throw new Exception(STR_ERROR_REMEMBER_TOKEN, 9);
		else
			$deal = Deal::find($deal_id);
			if(empty($deal))
				throw new Exception(STR_ERROR_DEAL_NOT_FOUND, 6);
			else
				$save_deal = SaveDeal::where('user_id','=',$user_id)->where('deal_id','=',$deal_id);
				if($save_deal->count() == 0)
					throw new Exception(STR_ERROR_DEAL_NOT_SAVED, 13);
				else
					$save_deal->delete();
	}
	/*
	* Buy deal
	*/
	public function BuyDeal($user_id,$remember_token,$deal_id)
	{
		$user = User::find($user_id);
		if(empty($user))
			throw new Exception(STR_ERROR_USER_NOT_FOUND, 8);
		elseif($user->remember_token != $remember_token)
			throw new Exception(STR_ERROR_REMEMBER_TOKEN, 9);
		else
			$deal = Deal::find($deal_id);
			if(empty($deal))
				throw new Exception(STR_ERROR_DEAL_NOT_FOUND, 6);
			else
				$time = date('Y-m-d');
				if($time < $deal->start_date || $time > $deal->end_date)
					throw new Exception(STR_ERROR_TIME, 14);
				elseif($deal->quantity < 1)
					throw new Exception(STR_ERROR_QUANTITY, 15);
				elseif($user->balance < $deal->price)
					throw new Exception(STR_ERROR_BALANCE, 16);
				else
					$deal->quantity = $deal->quantity - 1;
					$deal->save();
					$user->balance = $user->balance - $deal->price;
					$user->save();
					Bought::insert(['user_id' => $user_id,'deal_id' => $deal_id,'owner_email'=>$deal->own_email]);
					App::make('EmailController')->SendEmailToDealOwner($deal->own_email,$user->username,$deal->title);
					App::make('PdfController')->GenerateListBoughtPdf($deal->own_email,$deal_id);
											
	}
}
?>