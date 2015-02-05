<?php
class DbOccupationRepo extends \Exception implements OccupationRepo{
	public function __construct($message = '',$error_code = null)
	{
		
	}
	public function getAll()
	{
		return Occupation::get();
	}
}
?>