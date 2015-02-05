<?php
class Occupation extends Moloquent{
	protected $collection = 'occupations';
	protected $hidden = ['updated_at','created_at'];
}
?>