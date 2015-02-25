<?php

class State extends \Eloquent {

	protected $fillable = [];
	protected $table = 'states';
	protected $hidden = ['updated_at','created_at','location_id'];
	public function Location(){
		return $this->belongsTo('Location');
	}
	/**
	 * Relationship with Deal
	 */
	public function Deal(){
		return $this->hasMany('Deal','state_id','id');
	}
}