<?php
use Illuminate\Auth\UserInterface;
class DbUserRepository implements UserRepository, UserInterface{
	/**
	 * Select array of `users`
	 */
	protected $user_select_array = array('id','username','email','password','role_id');
	/**
	 * return all users
	 */
	public function getAuthIdentifier(){ 
		return $this->getKey(); 
	}
	

	public function getAuthPassword(){ 
		return $this->password; 
	}
	public function getRememberToken(){
	    return $this->remember_token;
	}

	public function setRememberToken($value){
	    $this->remember_token = $value;
	}

	public function getRememberTokenName(){
	    return 'remember_token';
	}
	/**
	 * return All User
	 */
	public function all(){
		return User::select($this->user_select_array)->get();
	}
	public function getAllUser($skip = 0,$take = 20,$orderBy = 'DESC')
	{
		return User::where('role_id','=',5)->skip($skip)->take($take)->orderBy('id',$orderBy)->get();
	}
	/**
	 * find user by $id
	 */
	public function find($id){
		return User::select($this->user_select_array)->find($id);
	}
	/**
	 * return  Agent
	 */
	public function Agent(){
		return User::where('role_id','=',3)->get();
	}
	/**
	 * Check user by $id
	 */
	public function CheckUser($id){
		if(empty(User::find($id)))
			return 'false';
		else
			return 'true';
	}
	/**
	 * check email exist
	 */
	public function CheckEmail($email){
		if(User::where('email','=',$email)->count() > 0)
			return 'true';
		else
			return 'false';
	}
	/**
	 * Check usename
	 */
	public function CheckUsername($username){
		if(User::where('username','=',$username)->count() > 0)
			return true;
		else
			return false;
	}
	/**
	 * Check Login
	 */
	public function CheckLogin($login_data){
		/**
		 * login data include email && password
		 */
		extract($login_data);
		if($this->CheckEmail($email) == 'false')
			/**
			 * Exception when email not foud
			 */
			throw new Exception(STR_ERROR_EMAIL_NOT_FOUND);
		elseif(Auth::attempt(array('email'=>$email,'password'=>$password)) == false)
			/**
			 * Exception when login fail
			 */
			throw new Exception(STR_ERROR_LOGIN_FAIL);
		else
			return Auth::user();
	}
	/*
	* ajax login
	*/
	public function Login($email,$password)
	{
		$vali = [
			'email'    => $email,
			'password' => $password,
		];
		$rules = [
			'email'    => ['required','email','max:40'],
			'password' => ['required','min:8','max:40'],
		];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_VALIDATE, 1);
		else
			if(Auth::attempt(['email'=>$email,'password'=>$password])){
				$user = Auth::user();
				Auth::login($user);
				return $user;
			}else{
				$check_email = User::where('email','=',$email)->count();
				if($check_email == 0)
					throw new Exception(STR_ERROR_EMAIL_NOT_FOUND, 5);
				else
					throw new Exception(STR_ERROR_PASSWORD_NOT_MATCH, 11);
			}
	}
	/**
	 * Insert Agent
	 */
	public function InsertAgent($username,$email,$password){
		$vali = [
			'username' => $username,
			'email'    => $email,
			'password' => $password,
			];
		$rules = [
			'username' => ['required','min:3','max:30'],
			'email'    => ['required','email','max:40'],
			'password' => ['required','min:6'],
			];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_VALIDATE, 1);
		else
			$count = User::where('username','=',$username)->count();
			if($count > 0)
				throw new Exception(STR_ERROR_USER_EXIST, 2);
			else
				$count = User::where('email','=',$email)->count();
				if($count > 0)
					throw new Exception(STR_ERROR_USER_EMAIL_EXIST, 3);
				else
					while (true) {
						$promocode = Str::random(10);
						if(User::where('promocode','=',$promocode)->count() == 0){
							break;
						}
					}
					$agent = new User();
					
					$agent->username  = $username;
					$agent->email     = $email;
					$agent->role_id   = 3;
					$agent->password  = Hash::make($password);
					$agent->promocode = $promocode;
					
					$agent->save();
					return $agent;
			
	}
	public function DeleteAgent($user_id){
		$vali  = ['user_id' => $user_id];
		$rules = ['user_id' => ['required','regex:/^[0-9]+$/']];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_VALIDATE, 1);
		else
			$auth = Auth::user();
			$user = User::find($user_id);
			if($auth->role_id > 2)
				throw new Exception(STR_ERROR_PERMISSION_DENIED, 2);
			elseif(empty($user))
				throw new Exception(STR_ERROR_USER_NOT_FOUND, 3);
			else
				$user->delete();
	}
	/**
	 * Remove User - location
	 */
	public function DeleteUserLocation($user_id,$location_id){
		$vali  = ['user_id' => $user_id,'location_id' => $location_id];
		$rules = [
			'user_id' => ['required','regex:/^[0-9]+$/'],
			'location_id' => ['required','regex:/^[0-9]+$/'],
		];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_VALIDATE, 1);
		else
			$auth = Auth::user();
			if($auth->role_id > 2)
				throw new Exception(STR_ERROR_PERMISSION_DENIED, 2);
			else
				$locations = UserLocation::where('user_id','=',$user_id)->where('location_id','=',$location_id);
				if($locations->count() > 0){
					foreach ($locations->get() as $location) {
						$location->delete();
					}
				}
	}
	/**
	 * Insert User - location
	 */
	public function InsertUserLocation($user_id,$location_id){
		$vali  = ['user_id' => $user_id,'location_id' => $location_id];
		$rules = [
			'user_id' => ['required','regex:/^[0-9]+$/'],
			'location_id' => ['required','regex:/^[0-9]+$/'],
		];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_VALIDATE, 1);
		else
			$auth = Auth::user();
			if($auth->role_id > 2)
				throw new Exception(STR_ERROR_PERMISSION_DENIED, 2);
			else
				$locations = UserLocation::where('user_id','=',$user_id)->where('location_id','=',$location_id);
				if($locations->count() > 0)
					throw new Exception(STR_ERROR_USER_LOCATION_EXISTS, 3);
				else
					UserLocation::insert(['user_id'=>$user_id,'location_id' => $location_id]);
	}
	/**
	 * Api login
	 */
	public function ApiLogin($email,$password){
		$vali = ['email' => $email, 'password' => $password];
		$rules = [
			'email'    => ['required','email','max:40'],
			'password' => ['required','min:8']
		];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_VALIDATE, 1);
		elseif(!Auth::attempt(['email' => $email, 'password' => $password, 'role_id' => 5]))
			throw new Exception(STR_ERROR_LOGIN_FAIL, 2);
		else
			$user = Auth::user();
			$user->remember_token = md5(Str::random(10));
			$user->save();
			return $user;

	}
	public function ApiRegister($username, $email, $password){
		$vali = [
			'username' => $username,
			'email'    => $email, 
			'password' => $password
		];
		$rules = [
			'username' => ['required','min:3','max:30','regex:/^[a-zA-Z0-9-_]+$/'],
			'email'    => ['required','email','max:40'],
			'password' => ['required','min:8']
		];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_VALIDATE, 1);
		elseif($this->CheckEmail($email) == 'true')
			throw new Exception(STR_ERROR_USER_EMAIL_EXIST, 3);
		elseif($this->CheckUsername($username) == true)
			throw new Exception(STR_ERROR_USER_EXIST, 4);
		else
			$remember_token = md5(Str::random(10));
			while(true){
				$promocode = Str::random(10);
				if(User::where('promocode','=',$promocode)->count() == 0){
					break;
				}
			}
			$user = new User();
			$user->username       = $username;
			$user->email          = $email;
			$user->password       = Hash::make($password);
			$user->role_id        = 5;
			$user->remember_token = $remember_token;
			$user->promocode      = $promocode;
			$user->save();
			
			return $user;
	}
	/**
	 * Check User && Remember_token
	 */
	public function CheckUserRememberToken($user_id,$remember_token){
		$vali = [
			'user_id'        => $user_id,
			'remember_token' => $remember_token,
		];
		$rules = [
			'user_id'        => ['required','regex:/^[0-9]+$/'],
			'remember_token' => ['required','regex:/^[a-zA-Z0-9]+$/'],
		];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_VALIDATE, 1);
		else
			$user = User::find($user_id);
			if(empty($user))
				throw new Exception(STR_ERROR_USER_NOT_FOUND, 8);
			elseif($user->remember_token != $remember_token)
				throw new Exception(STR_ERROR_REMEMBER_TOKEN, 9);
			else
				return true;
	}
	/**
	 * Check Rated
	 */
	public function CheckRated($user_id, $deal_id){
		$vali = [
			'user_id' => $user_id,
			'deal_id' => $deal_id,
		];
		$rules = [
			'user_id' => ['required','regex:/^[0-9]+$/'],
			'deal_id' => ['required','regex:/^[0-9]+$/'],
		];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_VALIDATE, 1);
		else
			$rated = UserRate::where('user_id','=',$user_id)
							 ->where('deal_id','=',$deal_id);
			if($rated->count() > 0)
				return ['data' => true, 'number_star' => $rated->first()->number_star];
			else
				return ['data' => false];
	}
	/**
	 * make forgot password token
	 */
	public function MakeForgotPasswordToken($email){
		$vali = ['email' => $email];
		$rules = ['email' => 'required|max:40|email'];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_VALIDATE, 1);
		else
			$user = User::where('email','=',$email);
			if($user->count() == 0)
				throw new Exception(STR_ERROR_USER_NOT_FOUND, 2);
			else
				$user = $user->first();
				$token = md5(Str::random(10));
				$user->forgot_token = $token;
				$user->save();
				return ['user_id' => $user->id,'forgot_token' => $token];
	}
	/*
	* New password
	*/
	public function NewPassword($user_id,$forgot_token,$password){
		$vali = [
			'user_id'      => $user_id,
			'forgot_token' => $forgot_token,
			'password'     => $password,
		];
		$rules = [
			'user_id'      => ['required','regex:/^[0-9]+$/'],
			'forgot_token' => ['required','regex:/^[a-zA-Z0-9]+$/'],
			'password'     => ['required'],
		];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_VALIDATE, 1);
		else
			$user = User::find($user_id);
			if(empty($user))
				throw new Exception(STR_ERROR_USER_NOT_FOUND, 2);
			elseif($user->forgot_token != $forgot_token)
				throw new Exception(STR_ERROR_FORGOT_TOKEN_NOT_MATCH, 3);
			else
				$user->password = Hash::make($password);
				$user->forgot_token = '';
				$user->save();
				Auth::login($user);
				return true;
	}
	/*
	* Remove user
	*/
	public function RemoveUser($user_id)
	{
		$user = User::find($user_id);
		if(empty($user))
			throw new Exception(STR_ERROR_USER_NOT_FOUND, 3);
		else
			$user->delete();		
	}
	/*
	* change user status active /deactive
	*/
	public function ChangeUserStatus($user_id,$status)
	{
		$user = User::find($user_id);
		if(empty($user))
			throw new Exception(STR_ERROR_USER_NOT_FOUND, 3);
		else
			$user->active = $status;
			$user->save();
			
	}
	/*
	* edit user info
	*/
	public function EditUser($user_id,$username,$email,$balance)
	{
		$vali = [
			'user_id'  => $user_id,
			'username' => $username,
			'email'    => $email,
			'balance'  => $balance,
		];
		$rules = [
			'user_id' => ['required','regex:/^[0-9]+$/'],
			'username' => ['required','regex:/^[a-zA-Z0-9_]+$/','max:40'],
			'email' => ['required','email','max:40'],
			'balance' => ['required','regex:/^[0-9|.]+$/'],
		];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_VALIDATE, 1);
		else
			$user = User::find($user_id);
			if(empty($user))
				throw new Exception(STR_ERROR_USER_NOT_FOUND, 3);
			else
				$user->username = $username;
				$user->email = $email;
				$user->balance = $balance;
				$user->save();
	}
}
?>