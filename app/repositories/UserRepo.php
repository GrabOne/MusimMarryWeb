<?php
interface UserRepo {
	public function LoginSocial($username,$email,$avatar,$age,$gender,$birthday,$facebook_id,$google_id,$twitter_id);
}
?>