<?php
class DbUserRepo extends \Exception implements UserRepo{
	protected $Promocode;
	public function __construct($message = '',$error_code = null,PromocodeRepo $Promocode)
	{
		$this->Promocode = $Promocode;
	}
	public function LoginSocial($nickname,$email,$avatar,$age,$gender,$birthday,$location,$facebook_id = null,$google_id = null,$twitter_id = null)
	{
		$type = '';
		if(isset($facebook_id) && $facebook_id != ''){
			$type = 'facebook';
		}elseif(isset($google_id) && $google_id){
			$type = 'google';
		}elseif(isset($twitter_id) && $twitter_id !=''){
			$type = 'twitter';
		}else{
			throw new Exception(STR_ERROR_VALIDATE, 1);
		}
		switch ($type) {
			case 'facebook':
				$user = User::where('facebook_id','=',$facebook_id);
				break;
			case 'google':
				$user = User::where('google_id','=',$google_id);
				break;
			case 'facebook':
				$user = User::where('twitter','=',$twitter_id);
				break;
		}
		if($user->count() > 0)
			return $user->first();
		else
			$vali = [
				'nickname' => $nickname,
				'email'    => $email,
				'age'      => $age,
				'gender'   => $gender,
				'birthday' => $birthday,
			];
			$validator = Validator::make($vali,User::$rules);
			if($validator->fails())
				throw new Exception($validator->messages(), 1);
			else
				$user = new User();
				$user->nickname       = $nickname;
				$user->email          = isset($email) ? strtolower($email) : '';
				$user->age            = isset($age) ? $age : '';
				$user->birthday       = isset($birthday) ? $birthday : '';
				$user->avatar         = isset($avatar) ? $avatar : '';
				$user->remember_token = Hash::make(Str::random(10));
				$user->location       = isset($location) ? $location : ["city" => '',"country" => '','coordinates' => ['lat'=>'','lng'=>'']];
				$user->gender         = isset($gender) ? $gender : '';


				switch ($type) {
					case 'facebook':
						$user->facebook_id = $facebook_id;
						break;
					case 'google':
						$user->google_id = $google_id;
						break;
					case 'facebook':
						$user->twitter_id = $twitter_id;
						break;
				}		
				$user->is_social = true;
				$user->password = '';
				$user->occupation = '';
				$user->height = '';
				$user->language = [];
				$user->promocode = $this->Promocode->GenerateCode();
				$user->save();
				return $user;
	}
	/*
	* signup with normal account
	*/
	public function SignUp($username,$email,$password,$age,$gender,$avatar,$location)
	{
		$vali = [
			'username' => $username,
			'email'    => $email,
			'age'      => $age,
			'gender'   => $gender,
		];
		$rules = User::$rules;
		$rules['username'] = 'required|max:40|regex:/^[a-zA-Z0-9-_]+$/';
		$rules['password'] = 'required|min:6|max:40';

		$validator = Validator::make($vali,User::$rules);
 		if($validator->fails())
			throw new Exception($validator->messages(), 1);
		else
			$check_username = User::where('username','=',$username)->count();
			$check_email = User::where('email','=',$email)->count();
			if($check_username > 0)
				throw new Exception(STR_ERROR_USERNAME_EIXST, 2);
			elseif($check_email > 0)
				throw new Exception(STR_ERROR_EMAIL_EXIST, 3);
			else
				$user = new User();
				$user->username       = strtolower($username);
				$user->nickname       = '';
				$user->email          = $email;
				$user->password       = $password;
				$user->age            = $age;
				$user->gender         = $gender;
				$user->avatar         = isset($avatar) ? $avatar : '';
				$user->location       = isset($location) ? $location : ["city" => "","country" => '','coordinates' => ['lat'=>'','lng'=>'']];
				$user->remember_token = Hash::make(Str::random(10));
				$user->occupation     = '';
				$user->height         = '';
				$user->language       = [];
				$user->promocode      = $this->Promocode->GenerateCode();
				$user->save();
				Cache::put('u_'.$user->_id,$user,CACHE_TIME);
				return $user;
	}
	/*
	* Check Remember Token
	*/
	public function checkRememberToken($user_id,$remember_token)
	{
		if(Cache::has('u_'.$user_id))
			$user = Cache::get('u_'.$user_id);
		else
			$user = User::find($user_id);
			if(empty($user))
				throw new Exception(Lang::get('validation.not_found',['attribute' => 'User']), 5);
			else
				if($user->remember_token != $remember_token)
					throw new Exception(STR_ERROR_REMEMBER_TOKEN, 7);
				else 
					Cache::put('u_'.$user_id,$user,CACHE_TIME);
					return $user;
	}
	/*
	* Update UserCache
	*/
	public function UpdateUserCache($user_id)
	{
		Cache::forget('u_'.$user_id);
		$user = User::find($user_id);
		Cache::put('u_'.$user_id,$user,CACHE_TIME);
		return $user;
	}
	/*
	* Normal login
	*/
	public function NormalLogin($username,$password)
	{
		$vali = [
			'username' => $username,
			'password' => $password,
		];
		$validator = Validator::make($vali,User::$LoginRules);
		if($validator->fails())
			throw new Exception($validator->messages(), 1);
		else
			$user = User::NormalLogin($username,$password);
			Cache::put('u_'.$user->_id,$user,CACHE_TIME);
			return $user;
			
	}
	/*
	* Edit social account
	*/
	public function EditSocialAccount($user,$nickname,$birthday,$occupation,$height,$city,$language)
	{
		$vali = [
			'nickname'   => $nickname,
			'birthday'   => $birthday,
			'occupation' => $occupation,
			'height'     => $height,
			'city'       => $city,
			'language'   => $language,
 		];
 		$rules = [
			'birthday'   => 'date',
			'occupation' => 'max:100',
			'height'     => 'regex:/^[0-9,\.]+$/|max:6',
			'city'       => 'max:100',
 		];
 		$validator = Validator::make($vali,$rules);
 		if($validator->fails())
 			throw new Exception($validator->messages(), 1);
 		else
			isset($nickname) ? $user->nickname     = $nickname : '';
			isset($birthday) ? $user->birthday     = $birthday : '';
			isset($occupation) ? $user->occupation = strtolower($occupation) : '';
			isset($height) ? $user->height         = $height : '';
			if(isset($city)){
				$location = $user->location;
				$location['city'] = $city;
				$user->location = $location;
			}
			if(isset($language)){
				$user->language = array_map('strtolower',$language);
			}
			$user->save();
			return $user;
	}
	/*
	* Change user avatar
	*/
	public function changeUserAvatar($user,$avatar)
	{
		$user->avatar = $avatar;
		$user->save();
		Cache::put('u_'.$user->id,$user,CACHE_TIME);
	}
	/*
	* Edit normal account
	*/
	public function EditNormalAccount($user,$username,$nickname,$birthday,$occupation,$height,$city,$language,$password)
	{
		$vali = [
			'username'   => $username,
			'birthday'   => $birthday,
			'occupation' => $occupation,
			'height'     => $height,
			'city'       => $city,
			'language'   => $language,
 		];
 		$rules = [
			'username'   => 'max:40|min:4|regex:/^[a-zA-Z0-9-_]/',
			'birthday'   => 'date',
			'occupation' => 'max:100',
			'height'     => 'regex:/^[0-9,\.]+$/|max:6',
			'city'       => 'max:100',
 		];
 		$validator = Validator::make($vali,$rules);
 		if($validator->fails())
 			throw new Exception($validator->messages(), 1);
 		else
			isset($username) ? $user->username     = strtolower($username) : '';
			isset($nickname) ? $user->nickname     = $nickname : '';
			isset($birthday) ? $user->birthday     = $birthday : '';
			isset($occupation) ? $user->occupation = strtolower($occupation) : '';
			isset($height) ? $user->height         = $height : '';
			if(isset($city)){
				$location = $user->location;
				$location['city'] = $city;
				$user->location = $location;
			}
			if(isset($language)){
				$user->language = array_map('strtolower', $language);
			}
			isset($password) ? $user->password = $password : '';
			$user->save();
			return $user;
	}
	public function Search($user_id,$u,$gender,$age,$distance,$language,$occupations,$height,$coordinates)
	{
		$vali = [
			'gender'      => $gender,
			'age'         => $age,
			'distance'    => $distance,
			'language'    => $language,
			'occupations' => $occupations,
			'height'      => $height,
			'coordinates' => $coordinates,
		];
		$rules = [
			'gender' => 'regex:/(wo)?men/',
		];
		$validator = Validator::make($vali,$rules);
		if($validator->fails())
			throw new Exception($validator->messages(), 1);
		else
			$data = [];
			$users = User::select('_id','occupation','age','gender','avatar','birthday','email','height','language','location','promocode','username','nickname')->get();

			foreach ($users as $user) {
				
				if($user->_id == $user_id){
					continue;
				}
				if($user->gender != $gender){
					continue;
				}
				$array_intersect = array_intersect($language,$user->language);
				if(count($array_intersect) == 0){
					continue;
				}
				if($user->height < $height['from'] || $user->height > $height['to']){
					continue;
				}
				/*
				* check block permanently
				*/
				if(isset($u->block_permanently) && count($u->block_permanently) > 0){
					if(in_array($user->_id, $u->block_permanently)){
						continue;
					}
				}
				/*
				* check block 30 day
				*/
				if(isset($u->block_30_day) && count($u->block_30_day) > 0){
					$check = false;
					foreach ($u->block_30_day as $block) {
						if($block['_id'] == $user->_id){
							$check = true;
							return true;
						}
					}
					if($check){
						continue;
					}
				}
				$dis = App::make('BaseController')->calcDistance($coordinates['lat'],$coordinates['lng'],$user->location['coordinates']['lat'],$user->location['coordinates']['lng']);
				

				if($dis < $distance['from'] || $dis > $distance['to']){
					continue;
				}else{
					$user->distance = $dis;
					array_push($data, $user);
				}
			}
			$count = count($data) - 1;
			if($count >= 0){
				for($i = 0; $i < $count; $i++){
					for($j = 0;$j<$count;$j++){
						if($data[$j] > $data[$j+1]){
							$tmp = $data[$j];
							$data[$j] = $data[$j+1];
							$data[$j+1] = $tmp;
						}
					}
				}
			}
			return $data;
			
	}
	public function getProfile($user_id)
	{
		if(Cache::has('u_'.$user_id))
			return Cache::get('u_'.$user_id);
		else
			$user = User::find($user_id);
			if(empty($user))
				throw new Exception(Lang::get('validation.not_found',['attribute' => 'User']), 5);
			else
				unset($user->remember_token);
				unset($user->facebook_id);
				unset($user->google_id);
				unset($user->twitter_id);
				return $user;
	}
	/*
	* check username exist
	*/
	public function CheckUsernameExist($username)
	{
		$count = User::where('username','=',$username)->count();
		if($count > 0)
			return ['exist' => true];
		else
			return ['exist' => false];
	}
	public function CheckEmailExist($email)
	{
		$count = User::where('email','=',$email)->count();
		if ($count > 0)
			return ['exist' => true];
		else
			return ['exist' => false];
	}

}
?>