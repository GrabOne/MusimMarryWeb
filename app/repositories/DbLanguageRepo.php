<?php
class DbLanguageRepo extends \Exception implements LanguageRepo{
	public function __construct($message = '', $error_code = null)
	{

	}
	public function getAll()
	{
		return Language::get();
	}
}
?>