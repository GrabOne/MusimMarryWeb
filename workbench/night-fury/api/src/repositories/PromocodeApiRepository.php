<?php
interface PromocodeApiRepository{
	public function UsePromocode($user_id,$remember_token,$promocode);
}
?>