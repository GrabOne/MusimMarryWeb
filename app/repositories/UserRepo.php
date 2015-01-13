<?php
interface UserRepo {
	public function LoginSocial($username,$email,$avatar,$age,$gender,$birthday,$location,$facebook_id,$google_id,$twitter_id);
	public function SignUp($username,$email,$password,$age,$gender,$avatar,$location);
}
?>