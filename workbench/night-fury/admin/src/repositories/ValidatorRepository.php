<?php
define('STR_ERROR_VALIDATION', 'Validation error');
class ValiatorRepository extends \Exception{
	public function __construct($message = null, $code = 0, Exception $previous = null){

	}
	public function ValidateDeal($input){
		$rules = array(
			'title' => array('required','max:100'),
			'address' => array('required','max:160'),
			);
		if(Validator::make($input,$rules)->fails())
			throw new Exception(STR_ERROR_VALIDATION,1);
	}
}
?>