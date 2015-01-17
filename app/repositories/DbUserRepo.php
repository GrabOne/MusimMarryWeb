<?php
class DbUserRepo extends \Exception implements UserRepo{
	public function __construct($message = '',$error_code = null)
	{

	}
	public function LoginSocial($username,$email,$avatar,$age,$gender,$birthday,$location,$facebook_id = null,$google_id = null,$twitter_id = null)
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
				'username' => $username,
				'email'    => $email,
				'age'      => $age,
				'gender'   => $gender,
				'birthday' => $birthday,
			];
			if(Validator::make($vali,User::$rules)->fails())
				throw new Exception(STR_ERROR_VALIDATE, 1);
			else
				$user = new User();
				$user->username       = $username;
				$user->email          = isset($email) ? $email : '';
				$user->age            = isset($age) ? $age : '';
				$user->birthday       = isset($birthday) ? $birthday : '';
				$user->avatar         = isset($avatar) ? $avatar : '';
				$user->remember_token = Hash::make(Str::random(10));
				$user->location       = isset($location) ? $location : [];


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
				$user->accupation = '';
				$user->height = '';
				$user->language = [];
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
 		if(Validator::make($vali,User::$rules)->fails())
			throw new Exception(STR_ERROR_VALIDATE, 1);
		else
			$check_username = User::where('username','=',$username)->count();
			$check_email = User::where('email','=',$email)->count();
			if($check_username > 0)
				throw new Exception(STR_ERROR_USERNAME_EIXST, 2);
			elseif($check_email > 0)
				throw new Exception(STR_ERROR_EMAIL_EXIST, 3);
			else
				$user = new User();
				$user->username       = $username;
				$user->email      = $email;
				$user->password       = Hash::make($password);
				$user->age            = $age;
				$user->gender         = $gender;
				$user->avatar         = isset($avatar) ? $avatar : '';
				$user->location       = isset($location) ? $location : [];	
				$user->remember_token = Hash::make(Str::random(10));
				$user->accupation = '';
				$user->height = '';
				$user->language = [];
				$user->save();
				Cache::put('u_'.$user->_id,$user,10);
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
		if($user->remember_token != $remember_token)
			throw new Exception(STR_ERROR_REMEMBER_TOKEN, 7);
		else 
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
		if(Validator::make($vali,User::$LoginRules)->fails())
			throw new Exception(STR_ERROR_VALIDATE, 1);
		else
			$user = User::NormalLogin($username,$password);
			Cache::put('u_'.$user->_id,$user,10);
			return $user;
			
	}
	/*
	* Edit social account
	*/
	public function EditSocialAccount($user,$username,$birthday,$occupation,$height,$city,$language)
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
			'username'   => 'max:40|min:4',
			'occupation' => 'max:100',
			'height'     => 'regex:/^[0-9,\.]+$/|max:6',
			'city'       => 'max:100',
 		];
 		if(Validator::make($vali,$rules)->fails())
 			throw new Exception(STR_ERROR_VALIDATE, 1);
 		else
			isset($username) ? $user->username     = $username : '';
			isset($birthday) ? $user->birthday     = $birthday : '';
			isset($occupation) ? $user->occupation = $occupation : '';
			isset($height) ? $user->height         = $height : '';
			if(isset($city)){
				$location = $user->location;
				$location['city'] = $city;
				$user->location = $location;
			}
			if(isset($language)){
				$user->language = $language;
			}

 			
	}
}
?>