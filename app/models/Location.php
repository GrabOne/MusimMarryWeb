<?php

class Location extends \Eloquent {
	protected $table = 'locations';
	protected $fillable = [];
	protected $hidden = ['updated_at','created_at'];
	/**
	 * Relationship with State 1 - n
	 */
	public function State(){
		return $this->hasMany('State','location_id','id')->select('id','state');
	}
	/**
	 * Relationship with Deal
	 */
	public function Deal(){
		return $this->hasMany('Deal','location_id','id');
	}
}