<?php
class ApiController extends Controller{
	protected $User;
	public function __construct(UserRepo $User)
	{
		$this->User = $User;
	}
	public function getIndex()
	{
		return 'Muslim Marry API v!.';
	}
	public function postLoginSocial()
	{
		try {
			extract(Input::only('username','email','avatar','age','gender','birthday','location','facebook_id','google_id','twitter_id'));

			$user = $this->User->LoginSocial($username,$email,$avatar,$age,$gender,$birthday,$location,$facebook_id,$google_id,$twitter_id);

			return App::make('BaseController')->Success($user);
		} catch (Exception $e) {
			return App::make('BaseController')->Error($e);	
		}
	}
	/*
	* Signup with normal account
	*/
	public function postSignup()
	{
		try {
			extract(Input::only('username','email','password','age','gender','avatar','location'));

			$user = $this->User->SignUp($username,$email,$password,$age,$gender,$avatar,$location);

			return App::make('BaseController')->Success($user);
		} catch (Exception $e) {
			return App::make('BaseController')->Error($e);	
		}
	}
	public function postUploadAvatar()
	{
		try {
			if(!Input::hasFile('image'))
				throw new Exception(STR_ERROR_FILE_NOT_FOUND, 4);
			else
				$file = Input::file('image');
	            if(!in_array($file->getClientOriginalExtension(),array('jpg','JPG','jpeg','JPEG','png','PNG','gif','GIF'))){          
	                throw new Exception();
	            }
	            $filename = STR_DIR_UPLOAD_AVATAR_IMAGE.'/'.time().'-'.rand(1,1000).'-'.$file->getClientOriginalName();
	            $filename = preg_replace('/[^a-zA-Z0-9_\/ %\[\]\.\(\)%&-]/s', '', $filename);
	            $file->move(STR_DIR_UPLOAD_AVATAR_IMAGE,$filename);
	            return ['status' => STR_STATUS_SUCCESS,'url' => asset($filename)];
		}catch(Exception $e){
          	return App::make('BaseController')->Error($e);
        }
	}
	/*
	* Change user avatar
	*/
	public function putChangeAvatar()
	{
		try {
			extract(Input::only('user_id','remember_token','avatar'));
			$user = $this->User->checkRememberToken($user_id,$remember_token);
			$this->User->changeUserAvatar($user,$avatar);
			return App::make('BaseController')->Success();
		} catch (Exception $e) {
			return App::make('BaseController')->Error($e);
		}
	}
	public function postLogin()
	{
		try {
			extract(Input::only('username','password'));
			$user = $this->User->NormalLogin($username,$password);
			return App::make('BaseController')->Success($user);
		} catch (Exception $e) {
			return App::make('BaseController')->Error($e);
		}
	}
	/*
	* Edit social account
	*/
	public function putEditSocialAccount()
	{
		try {
			extract(Input::only('user_id','remember_token','username','birthday','occupation','height','city','language'));
			
			$user = $this->User->checkRememberToken($user_id,$remember_token);
			
			$this->User->EditSocialAccount($user,$username,$birthday,$occupation,$height,$city,$language);
			
			return App::make('BaseController')->Success($user);
		} catch (Exception $e) {
			return App::make('BaseController')->Error($e);
		}
	}
	/*
	*Edit normal account
	*/
	public function putEditNormalAccount()
	{
		try {
			extract(Input::only('user_id','remember_token','username','birthday','occupation','height','city','language','password'));
			
			$user = $this->User->checkRememberToken($user_id,$remember_token);
			
			$this->User->EditNormalAccount($user,$username,$birthday,$occupation,$height,$city,$language,$password);
			
			return App::make('BaseController')->Success($user);
		} catch (Exception $e) {
			return App::make('BaseController')->Error($e);
		}
	}
	/*
	* Search
	*/
	public function postSearch()
	{
		try {
			extract(Input::all('user_id','remember_token','gender','age','distance','language','occupations','height','coordinates'));

			$this->User->checkRememberToken($user_id,$remember_token);

			$data = $this->User->Search($gender,$age,$distance,$language,$occupations,$height,$coordinates);
			
			return ['status' => 'success', 'data' => $data];
		} catch (Exception $e) {
			return App::make('BaseController')->Error($e);
		}
	}
	public function getProfile($user_id)
	{
		try {
			$user = $this->User->getProfile($user_id);
			return App::make('BaseController')->Success($user);
		} catch (Exception $e) {
			return App::make('BaseController')->Error($e);
		}
	}
}
?>