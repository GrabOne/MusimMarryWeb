<?php
class ApiController extends Controller{
	protected $User;
	public function __construct(UserRepo $User)
	{
		$this->User = $User;
	}
	public function getIndex()
	{
		return 'Muslim Marry API v!.';
	}
	public function postLoginSocial()
	{
		try {
			extract(Input::only('username','email','avatar','age','gender','birthday','location','facebook_id','google_id','twitter_id'));

			$user = $this->User->LoginSocial($username,$email,$avatar,$age,$gender,$birthday,$location,$facebook_id,$google_id,$twitter_id);

			return App::make('BaseController')->Success($user);
		} catch (Exception $e) {
			return App::make('BaseController')->Error($e);	
		}
	}
	/*
	* Signup with normal account
	*/
	public function postSignup()
	{
		try {
			extract(Input::only('username','email','age','gender','avatar','location'));
			$user = $this->User->SignUp($username,$email,$age,$gender,$avatar,$location);
			return App::make('BaseController')->Success($user);
		} catch (Exception $e) {
			return App::make('BaseController')->Error($e);	
		}
	}
}
?>