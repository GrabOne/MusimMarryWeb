<?php
interface UserRepo {
	public function LoginSocial($nickname,$email,$avatar,$age,$gender,$birthday,$location,$facebook_id,$google_id,$twitter_id);
	public function SignUp($username,$email,$password,$age,$gender,$avatar,$location);
	public function NormalLogin($username,$password);
	/*
	* Check RememberToken
	*/
	public function checkRememberToken($user_id,$remember_token);
	/*
	* Edit social Account
	*/
	public function EditSocialAccount($user,$nickname,$birthday,$occupation,$height,$city,$language);
	/*
	* Change user avatar
	*/
	public function changeUserAvatar($user,$avatar);
	/*
	* Edit normal account
	*/
	public function EditNormalAccount($user,$username,$nickname,$birthday,$occupation,$height,$city,$language,$password);
	/*
	* Search Profile
	*/
	public function Search($user_id,$gender,$age,$distance,$language,$occupations,$height,$coordinates);
	/*
	* get user profile
	*/
	public function getProfile($user_id);
	/*
	* check username exist
	*/
	public function CheckUsernameExist($username);
	/*
	* check Email exist
	*/
	public function CheckEmailExist($email);
	
}
?>