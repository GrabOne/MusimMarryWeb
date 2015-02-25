<?php

class DealRate extends \Eloquent {
	protected $fillable = [];
	protected $table = 'deal_rate';
	protected $hidden = ['updated_at','created_at','deal_id','id'];
	/**
	 * Relationship With Deal
	 */
	public function Deal(){
		return $this->belongTo('Deal');
	}
}