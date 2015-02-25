<?php
class DbPromocodeApiRepository extends \Exception implements PromocodeApiRepository{
	public function __construct($message = '',$error_code = null)
	{
		
	}
	public function UsePromocode($user_id,$remember_token,$promocode)
	{
		$user = User::find($user_id);
		if(empty($user))
			throw new Exception(STR_ERROR_USER_NOT_FOUND, 8);
		elseif($user->remember_token != $remember_token)
			throw new Exception(STR_ERROR_REMEMBER_TOKEN, 9);
		else
			return true;
	}
}
?>