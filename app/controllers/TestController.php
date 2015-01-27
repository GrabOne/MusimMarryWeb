<?php
class TestController extends Controller{
	public function getPay()
	{
		$data = [
			'client_token' => App::make('PaymentController')->GenerateClientToken(),
		];
		return View::make('payment.paypal',$data);
	}
	public function postPay()
	{
		return var_dump(Input::all());
	}
}
?>