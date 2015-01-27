<?php
class PaymentController extends Controller{
	public function __construct()
	{
		Braintree_Configuration::environment($_ENV['BRAINTREE_ENV']);
		Braintree_Configuration::merchantId($_ENV['BRAINTREE_MERCHANT_ID']);
		Braintree_Configuration::publicKey($_ENV['BRAINTREE_PUBLIC_KEY']);
		Braintree_Configuration::privateKey($_ENV['BRAINTREE_PRIVATE_KEY']);
	}
	public function Transition($amount,$creditCard)
	{
		$result = Braintree_Transaction::sale(array(
		    'amount' => $amount,
		    'creditCard' => array(
		        'number' => $creditCard['number'],
		        'expirationMonth' => $creditCard['expirationMonth'],
		        'expirationYear' => $creditCard['expirationYear'],
		    )
		));
		return $result;
	}
	public function getAllPlan()
	{
		$plans = Braintree_Plan::all();
		return $plans;
	}
	public function CardVerification()
	{

	}
	public function CreateCustomer($firstName,$lastName,$creditCard)
	{
		$result = Braintree_Customer::create(array(
		    'firstName' => $firstName,
		    'lastName' => $lastName,
		    'creditCard' => array(
		        'cardholderName' => $creditCard['cardholderName'],
		        'number' => $creditCard['number'],
		        'cvv' => $creditCard['cvv'],
		        'expirationMonth' => $creditCard['expirationMonth'],
		        'expirationYear' => $creditCard['expirationYear'],
		        'options' => array(
		            'verifyCard' => true
		        )
		    )
		));
		return $result;
	}
	public function CreateSubscription($token,$plan_id)
	{
		$result = Braintree_Subscription::create(array(
		   'paymentMethodToken' => $token,
		   'planId' => $plan_id
		));
		return $result;
	}
	public function GenerateClientToken()
	{
		$clientToken = Braintree_ClientToken::generate();
		return $clientToken;
	}
	public function PayWithNonce($nonce,$amount)
	{
		$result = Braintree_Transaction::sale(array(
		    'amount' => $amount,
		    'paymentMethodNonce' => $nonce
		));
		return $result;
	}
	/*
	* Subscription with nonce form client
	*/
	public function SubscriptionWithNonce($nonce,$plan_id)
	{
		$result = Braintree_Subscription::create(array(
		   'paymentMethodNonce' => $nonce,
		   'planId' => $plan_id,
		));
		return $result;
	}
	/*
	* create customer with nonce from client
	*/
	public function CreateCustomerWithNonce($user_id,$email)
	{
		$result = Braintree_Customer::create(array(
			'id'                 => $user_id,
			'email'              => $email,
		));
		return $result;
	}
	/*
	* Delete customer
	*/
	public function DeleteCustomer($customer_id)
	{
		$result = Braintree_Customer::delete($customer_id);
		return $result;
	}
	/*
	* find a customer
	*/
	public function FindCustomer($customer_id)
	{
		$customer = Braintree_Customer::find($customer_id);
		return $customer;
	}
	/*
	* get All Customer
	*/
	public function getAllCustomer()
	{
		$customers = Braintree_Customer::all();
		return $customers;
	}
	/*
	* Create a payment method
	*/
	public function CreatePaymentMethod($customer_id,$nonce)
	{
		$result = Braintree_PaymentMethod::create(array(
		    'customerId' => $customer_id,
		    'paymentMethodNonce' => $nonce,
		));
		return $result;
	}


}
?>