<?php

class Deal extends \Eloquent {
	protected $fillable = [];
	protected $hidden = ['updated_at','created_at','category_id','location_id','state_id'];
	/**
	 * Relationship With Location
	 */
	public function Location(){
		return $this->belongsTo('Location');
	}
	/**
	 * Relationship With State
	 */
	public function State(){
		return $this->belongsTo('State');
	}
	/**
	 * Relationship With Categories
	 */
	public function Category(){
		return $this->belongsTo('Categories');
	}
	/**
	 * Relationship With User
	 */
	public function User(){
		return $this->belongsTo('User');
	}

	/**
	 * Relationship With DealRate
	 */
	public function DealRate(){
		return $this->hasOne('DealRate','deal_id','id');
	}
	/*
	* Relationship with DealLocation
	*/
	public function DealLocation()
	{
		return $this->hasOne('DealLocation','deal_id','id');
	}
}