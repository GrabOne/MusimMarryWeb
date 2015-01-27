<?php
interface PaymentRepo {
	public function CreateCustomer($user);
	public function CreatePaymentMethodToken($customer_id,$nonce);
	public function CreateSubscription($user,$token,$plan_id);
}
?>