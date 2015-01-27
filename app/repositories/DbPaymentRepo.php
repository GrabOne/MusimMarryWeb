<?php
class DbPaymentRepo extends \Exception implements PaymentRepo{
	public function __construct($message = '',$error_code = null)
	{

	}
	public function CreateCustomer($user){
		$customer    = App::make('PaymentController')->CreateCustomerWithNonce($user->_id,$user->email);
		if($customer->success == false)
			throw new Exception($customer->message);	
		else
			$customer_id = $customer->customer->id;
			$user->customer_id = $customer_id;
			$user->save();
			return $customer_id;
	}
	public function CreatePaymentMethodToken($customer_id,$nonce)
	{
		$paymentMethod = App::make('PaymentController')->CreatePaymentMethod($customer_id,$nonce);
		if($paymentMethod->success == false)
			throw new Exception($paymentMethod->message);
		else
			$token = $paymentMethod->paymentMethod->_attributes['token'];
			return $token;
	}
	/*
	* Create Subscription
	*/
	public function CreateSubscription($user,$token,$plan_id)
	{
		$subscription = App::make('PaymentController')->CreateSubscription($token,$plan_id);
		if($subscription->success == false)
			throw new Exception($subscription->message);
		else
			$subscription_id = $subscription->subscription->id;
			$user->subscription_id = $subscription_id;
			$user->save();
			return $subscription;
	}
}
?>