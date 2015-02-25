<?php
class AjaxController extends Controller{
	protected $categories;
	protected $location;
	protected $users;
	protected $deal;
	protected $upload;
	public function __construct(CategoryRepository $categories,LocationRepository $location,UserRepository $users, DealRepository $deal, UploadRepository $upload){
		/**
		 * Use CategoryRepository [dir repositories/CategoryRepository.php]
		 */
		$this->categories = $categories;
		/**
		 * Use LocationRepository [dir repositories/LocationRepository.php]
		 */
		$this->location = $location;
		/**
		 * Use UserRepository [dir repositories/UserRepository.php]
		 */
		$this->users = $users;
		/**
		 * User DealRepository [dir repositories/DealRepository.php]
		 */
		$this->deal = $deal;
		$this->upload = $upload;
	}
	/**
	 * AJAX Upload deal image /admin/upload-deal-image
	 */
	public function postUploadDealImage(){
		$file = Input::file('image');
		try {
			$url = $this->upload->UploadImage($file);
			$data = [
				'status' => STR_STATUS_SUCCESS,
				'url' => $url
			];
			return $url;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
	/*
	*  AJAX Save new deal
	*/
	public function postSaveDeal()
	{
		try {
			extract(Input::only('deal','image','location','state','category','deal_location','time_sensitive','time_sensitive_header'));	
			$deal_id = Input::get('deal_id');
			if(!isset($deal_id)){
				$deal_id = NEW_DEAL;
			}
			$this->deal->SaveDeal($deal,$image,$location, $state,$category,$deal_location,$deal_id,$time_sensitive,$time_sensitive_header);
			return App::make('BaseController')->ReturnSuccess();
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);			
		}	
	}
	/*
	* web backend login
	*/
	public function postLogin()
	{
		try {
			extract(Input::only('email','password'));
			$this->users->Login($email,$password);
			return App::make('BaseController')->ReturnSuccess();
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);
		}
	}
	/**
	 * Insert Category POST /ajax/category
	 */
	public function postInsertCategory(){
		try {
			$category = Input::get('category');
			$data = [
				'status' => STR_STATUS_SUCCESS,
				'category' => [
					'id' => $this->categories->Insert($category,1),
					'name' => $category,
				],
			];
			
			return $data;
		} catch (Exception $e) {
			return ['status'=>STR_STATUS_ERROR,'error_code'=>$e->getCode(),'message'=>$e->getMessage()];
		}
	}
	/**
	 * Delete Category DELETE /ajax/delete-category
	 */
	public function deleteDeleteCategory(){
		try {
			$this->categories->Delete(Input::get('category_id'));
			return ['status'=>STR_STATUS_SUCCESS];
		} catch (Exception $e) {
			return ['status'=>STR_STATUS_ERROR,'error_code'=>$e->getCode(),'message'=>$e->getMessage()];
		}
	}
	/**
	 * Insert location POST /ajax/insert-location
	 */
	public function postInsertLocation(){
		try {
			$location = Input::get('location');
			$location_id = $this->location->InsertLocation($location,'',1);
			$data = [
				'status'   =>STR_STATUS_SUCCESS,
				'location' =>[
						'id'       => $location_id,
						'location' => $location,
						'state'    => []
				],
			];			
			return $data;
		} catch (Exception $e) {
			return ['status'=>STR_STATUS_ERROR,'error_code'=>$e->getCode(),'message'=>$e->getMessage()];
		}
	}
	/**
	 * Remove location
	 */
	public function postDeleteLocation(){
		try {
			$this->location->DeleteLocation(Input::get('location_id'));
			return ['status' => STR_STATUS_SUCCESS];
		} catch (Exception $e) {
			return ['status'=>STR_STATUS_ERROR,'error_code'=>$e->getCode(),'message'=>$e->getMessage()];
		}
	}
	/**
	 * Insert State POST /ajax/insert-state
	 */
	public function postInsertState(){
		try {
			$location_id = Input::get('location_id');
			$state       = Input::get('state');
			$newState = $this->location->InsertState($location_id,$state);
			return ['status' => STR_STATUS_SUCCESS,'state' => $newState];
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);
		}
	}
	/**
	 * Delete state POST /ajax/delete-state
	 */
	public function postDeleteState(){
		try {
			$this->location->DeleteState(Input::get('state_id'));
			return ['status' => STR_STATUS_SUCCESS];
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);
		}
	}
	/**
	 * Check Location POST /ajax/check-location
	 */
	public function postCheckLocation(){
		try {
			return $this->location->CheckLocation(Input::get('location'));
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);
		}
	}
	/**
	 * Check State POST /ajax/check-state
	 */
	public function postCheckState(){
		try {
			return $this->location->CheckState(Input::get('state'),Input::get('location_id'));
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);
		}
	}
	/**
	 * Add agent POST /ajax/insert-agent
	 */
	public function postInsertAgent(){
		try {
			$agent = $this->users->InsertAgent(Input::get('username'),Input::get('email'),Input::get('password'));
			return ['status'=>STR_STATUS_SUCCESS,'agent' => $agent];
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);
		}
	}
	/**
	 * Remove Agent
	 */
	public function postDeleteAgent(){
		try {
			$this->users->DeleteAgent(Input::get('user_id'));
			return ['status' => STR_STATUS_SUCCESS];
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);	
		}
	}
	/*
	* Delete user_location POST /ajax/delete-user-location
	*/
	public function postDeleteUserLocation(){
		try {
			$this->users->DeleteUserLocation(Input::get('user_id'),Input::get('location_id'));
			return ['status' => STR_STATUS_SUCCESS];
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);	
		}
	}
	/**
	 * Insert user - location POST ajax/insert-user-location
	 */
	public function postInsertUserLocation(){
		try {
			$location = Location::find(Input::get('location_id'));
			$this->users->InsertUserLocation(Input::get('user_id'),Input::get('location_id'));
			return ['status' => STR_STATUS_SUCCESS,'location' => $location];
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);	
		}
	}
	/**
	 * Remove deal
	 */
	public function postRemoveDeal(){
		try {
			extract(Input::only('id'));
			$this->deal->RemoveDeal($id);
			return ['status' => STR_STATUS_SUCCESS];
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);	
		}
	}
	/*
	* remove user
	*/
	public function postRemoveUser()
	{
		try {
			extract(Input::only('user_id'));
			$this->users->RemoveUser($user_id);
			App::make('BaseController')->ReturnSuccess();
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);
		}	
	}
	/*
	* change user status
	*/
	public function postChangeUserStatus()
	{
		try {
			extract(Input::only('user_id','status'));
			$this->users->ChangeUserStatus($user_id,$status);
			return App::make('BaseController')->ReturnSuccess();
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);
		}
	}
	/*edit user info */
	public function postEditUser()
	{
		try {
			extract(Input::only('user_id','username','email','balance'));
			$this->users->EditUser($user_id,$username,$email,$balance);
			return App::make('BaseController')->ReturnSuccess();	
		} catch (Exception $e) {
			return App::make('BaseController')->ReturnError($e);
		}	
	}	
	public function getPdf($deal_id)
	{
		$deal = Deal::find($deal_id);
		if(empty($deal))
			return 'error';
		else
			$owner_email = $deal->own_email;
			if(!isset($owner_email) || $owner_email == '')
				return 'error';
			else
				return View::make('pdf');
	}
}
?>