<?php
use Illuminate\Auth\UserInterface;
class User extends Moloquent implements UserInterface{
	protected $collection = 'users';
	protected $hidden = ['password','updated_at','created_at'];
	public static $rules = [
        'username'    => 'max:40|regex:/^[a-zA-Z0-9]+$/',
        'email'       => 'required|max:40|email',
        'age'         => 'regex:/^[0-9]+$/|max:2',
        'birthday'    => 'regex:/([0-9]{4})-([0-9]{2})-([0-9]{2})/',
        'gender'      => 'regex:/(wo)?men/',
        'facebook_id' => 'regex:/^[0-9]+$/|max:20|min:6'
	];
	public static $LoginRules = [
		'username' => 'required|max:40|regex:/^[a-zA-Z0-9]+$/',
		'password' => 'required|min:6|max:40',
	];
	public function setRememberToken($value)
    {
        $this->remember_token = Hash::make($value);
    }
    public static function NormalLogin($username,$password)
    {
    	if(Auth::attempt(['username' => $username,'password' => $password]))
    		return Auth::user();
    	elseif(User::where('username','=',$username)->count() == 0)
    		throw new Exception(Lang::get('validation.not_found',['attribute' => 'Username']), 5);
    	else
    		throw new Exception(Lang::get('validation.not_match',['attribute' => 'Password']), 6);
    }
    /*
    * Hash password
    */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
    /*
    * UserInterface 
    */
    public function getAuthIdentifier()
    {
    	return $this->_id;
    }
    public function getAuthPassword()
    {
    	return $this->password;
    }
    public function getRememberToken()
    {
    	return $this->remember_token;
    }
    public function getRememberTokenName()
    {
    	return 'remember_token';
    }
}
?>