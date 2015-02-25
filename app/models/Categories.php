<?php

class Categories extends \Eloquent {
	protected $table = 'categories';
	protected $fillable = [];
	protected $hidden = ['updated_at','created_at'];
	/**
	 * Relationship with Deal
	 */
	public function Deal(){
		return $this->hasMany('Deal','category_id','id');
	}
}