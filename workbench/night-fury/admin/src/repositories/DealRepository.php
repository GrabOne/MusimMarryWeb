<?php
interface DealRepository{
	public function All($role = null);
	/**
	 * Remove Deal
	 */
	public function RemoveDeal($id);
	/*
	* Save deal
	*/
	public function SaveDeal($deal,$image,$location, $state, $category, $deal_location,$deal_id = NEW_DEAL,$time_sensitive,$time_sensitive_header);
}
?>