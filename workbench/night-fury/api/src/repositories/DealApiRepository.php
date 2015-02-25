<?php
interface DealApiRepository{
	public function All($skip,$take,$orderBy = 'DESC');
	/**
	 * Rate a Deal
	 */
	public function RateDeal($user_id, $deal_id, $number_star);
	/**
	 * Deal Available
	 */
	public static function DealAvailable($skip,$take,$orderBy = 'DESC');
	/**
	 * Search Deals With postcode
	 */
	public function SearchWithPostCode($postcode,$skip,$take);
	/**
	 * Search Deals With Distance
	 */
	public function NearMe($distance, $lat, $lng,$skip,$take);
	/**
	 * Caculate Distance
	 */
	public function calcDistance($lat1,$lng1, $lat2, $lng2);
	/**
	 * Search With Location_id
	 */
	public function SearchWithLocationId($location_id, $skip, $take, $orderBy = 'DESC');
	/**
	 * Search With state_id
	 */
	public function SearchWithStateId($state_id, $skip, $take, $orderBy = 'DESC');

	/*
	* Save deal
	*/
	public function SaveDeal($user_id,$remember_token,$deal_id);
	/*
	* GET List deal saved
	*/
	public function getListSaved($user_id,$remember_token);
	/*
	* Check save deal
	*/
	public function CheckSaveDeal($user_id,$remember_token,$deal_id);
	/*
	* remove save deal
	*/
	public function RemoveSaveDeal($user_id,$remember_token,$deal_id);
	/*
	* buy deal
	*/
	public function BuyDeal($user_id,$remember_token,$deal_id);
}
?>