<?php
interface LocationRepository{
	/**
	 * get all location
	 */
	public function AllLocation($orderBy = 'ASC');
	/**
	 * Insert new location, if $type == 1 => return new location id
	 */
	public function InsertLocation($location,$zipcode = '',$type = null);
	/**
	 * Delete location
	 */
	public function DeleteLocation($location_id);
	/**
	 * get all state in location
	 */
	public function LocationState($role = null,$orderBy = 'ASC');
	/**
	 * Insert state
	 */
	public function InsertState($location_id,$state,$zipcode = '');
	/**
	 * Remove State 
	 */
	public function DeleteState($state_id);
	/**
	 * Check Location
	 */
	public function CheckLocation($location);
	/**
	 * Check State
	 */
	public function CheckState($state,$location_id);
}
?>