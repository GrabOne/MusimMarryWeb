<?php
class DbUserRepo extends \Exception implements UserRepo{
	public function __construct($message = '',$error_code = null)
	{

	}
	public function LoginSocial($username,$email,$avatar,$age,$gender,$birthday,$facebook_id = null,$google_id = null,$twitter_id = null)
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
				$user->save();
				return $user;

	}
}
?>