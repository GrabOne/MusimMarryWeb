<?php
class Bought extends Eloquent{
	protected $table = 'bought';
	protected $hidden = ['updated_at','created_at'];
}
?>