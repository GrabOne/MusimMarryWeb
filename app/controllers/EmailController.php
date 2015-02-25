<?php
class EmailController extends Controller{
	public static function SendEmailToDealOwner($owner_email,$username,$deal_title)
	{
		$data = [
			'username'    => $username,
			'deal_title'  => $deal_title,
			'owner_email' => $owner_email,
		];	
		Mail::send('emails.owner_email', $data, function($message) use($owner_email)
		{
		    $message->to($owner_email, 'Deal')->subject('Grabone - Deal');
		});
	}
}
?>