<?php
class DbPromocodeRepo extends \Exception implements PromocodeRepo{
	public function __construct($message = '',$error_code = null)
	{

	}
	public function GenerateCode()
	{
		$promocode = Str::random(6);
		while(User::where('promocode','=',$promocode)->count() > 0){
			$promocode = Str::random(6);
		}
		return $promocode;
	}
}
?>