<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	protected $location_select_array = ['locations.id','locations.location'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password','updated_at','created_at');
	/**
	 * Relationship with Location
	 */
	public function Location(){
		return $this->belongsToMany('Location','user_location','user_id','location_id');
	}
	/**
	 * Relationship with Deal
	 */
	public function Deal(){
		return $this->hasMany('Deal','user_id','id');
	}
	public function DealSaved()
	{
		return $this->belongsToMany('Deal','save_deal','user_id','deal_id');
	}

}
