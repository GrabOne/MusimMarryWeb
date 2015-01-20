<?php
interface UserRepo {
	public function LoginSocial($username,$email,$avatar,$age,$gender,$birthday,$location,$facebook_id,$google_id,$twitter_id);
	public function SignUp($username,$email,$password,$age,$gender,$avatar,$location);
	public function NormalLogin($username,$password);
	/*
	* Check RememberToken
	*/
	public function checkRememberToken($user_id,$remember_token);
	/*
	* Edit social Account
	*/
	public function EditSocialAccount($user,$username,$birthday,$occupation,$height,$city,$language);
	/*
	* Change user avatar
	*/
	public function changeUserAvatar($user,$avatar);
	/*
	* Edit normal account
	*/
	public function EditNormalAccount($user,$username,$birthday,$occupation,$height,$city,$language,$password);
}
?>