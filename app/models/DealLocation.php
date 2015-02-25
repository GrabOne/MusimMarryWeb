<?php
class DealLocation extends Eloquent{
	protected $table = 'deal_location';
	protected $hidden = ['updated_at','created_at'];

	/*
	* Relationship with deal
	*/
	public function Deal()
	{
		return $this->belongsTo('Deal');
	}
}
?>