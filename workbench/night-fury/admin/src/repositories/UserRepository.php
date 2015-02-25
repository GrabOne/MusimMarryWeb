<?php
interface UserRepository{
	/**
	 * return data of all users
	 */
	public function all();
	public function getAllUser($skip = 0,$take = 20,$orderBy = 'DESC');
	/**
	 * return data of user who has id is $id
	 */
	public function find($id);
	/**
	 * return Agent
	 */
	public function Agent();
	/**
	 * will return (string) true if isset an user has id is $id or not is (string) false 
	 */
	public function CheckUser($id);
	/**
	 * Check email exist
	 */
	public function CheckEmail($email);
	/**
	 * Check username
	 */
	public function CheckUsername($username);
	/**
	 * Check Login
	 */
	public function CheckLogin($login_data);
	/*
	* ajax login
	*/
	public function Login($email,$password);
	/**
	 * Insert Agent
	 */
	public function InsertAgent($username, $email, $password);
	/**
	 * Remove Agent
	 */
	public function DeleteAgent($user_id);
	/**
	 * Remove User - location
	 */
	public function DeleteUserLocation($user_id,$location_id);
	/**
	 * insert User - location
	 */
	public function InsertUserLocation($user_id,$location_id);
	/**
	 * Api login
	 */
	public function ApiLogin($email,$password);
	/**
	 * API Register
	 */
	public function ApiRegister($username, $email, $password);
	/**
	 * Check user && remember_token
	 */
	public function CheckUserRememberToken($user_id,$remember_token);
	/**
	 * Check Rated 
	 */
	public function CheckRated($user_id, $deal_id);
	/**
	 * Make forgot password token
	 */
	public function MakeForgotPasswordToken($email);
	/**
	 * Make new password
	 */
	public function NewPassword($user_id,$forgot_token,$password);
	/*
	* Remove User
	*/
	public function RemoveUser($user_id);
	/*
	* Change user status active /deactive
	*/
	public function ChangeUserStatus($user_id,$status);
	/*
	* Edit user info
	*/
	public function EditUser($user_id,$username,$email,$balance);
}
?>