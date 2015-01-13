<?php
class User extends Moloquent{
	protected $collection = 'users';
	protected $hidden = ['password','updated_at','created_at'];
	public static $rules = [
		'username' => 'required|max:40',
		'email'    => 'required|max:40|email',
		'age'      => 'regex:/^[0-9]+$/|max:2',
		'birthday' => 'regex:/([0-9]{4})-([0-9]{2})-([0-9]{2})/',
	];

	public function setRememberToken($value)
    {
        $this->remember_token = Hash::make($value);
    }
}
?>