<?php 

class AdminController extends Controller{
	protected $auth;
	protected $users;
	protected $locations;
	protected $categories;
	protected $upload;
	protected $validator;
	protected $location;
	protected $deal;
	public function __construct(
			UserRepository $users,
			LocationRepository $locations,
			CategoryRepository $categories,
			ValiatorRepository $validator,
			UploadRepository $upload,
			LocationRepository $location,
			DealRepository $deal)
	{

		/**
		 * Filter CSRF
		 */
		$this->beforeFilter('csrf',array('on' => array('post','put','delete')));	
		$this->auth = Auth::user();
		/**
		 * Use UserRepository [dir: repositories/UserRepository.php] 
		 */
		$this->users     = $users;
		/**
		* Use LocationRepository [dir: repositories/LocationRepository.php]
		*/
		$this->locations = $locations;
		/**
		* Use CategoryRepository [dir repositories/CategoryRepository.php]
		*/
		$this->categories = $categories;
		/**
		 * Use ValidatorRepository [dir repositories/ValidatorRepository.php]
		 */
		$this->validator = $validator; 
		/**
		 * Use UploadRepository [dir repositories/UploadRepository.php]
		 */
		$this->upload = $upload;
		/**
		 * Use LocationRepository [dir repositories/LocationRepository]
		 */
		$this->location = $location;
		/**
		 * Use DealRepository [dir repositories/DealRepository.php]
		 */
		$this->deal = $deal;
	}
	public function getIndex()
	{
		return Redirect::to('admin/home');
	}
	public function postTest()
	{
		return 'a';
	}
	/**
	 * Forgot password
	 */
	public function getForgotPassword()
	{
		return View::make('admin.forgot_password')->with('title','Forgot Password');
	}
	public function postForgotPassword()
	{
		try {
			$email  = Input::get('email');
			$forgot = $this->users->MakeForgotPasswordToken($email);
			$link   = asset('admin/new-password').'/'.$forgot['user_id'].'/'.$forgot['forgot_token'];
			$data = [
				'email' => $email,
				'link'  => $link,
			];
			Mail::send('emails.forgot_password', $data, function($message) {
			    $message->to(Input::get('email'), 'Agent')->subject('Grabone - Forgot Password');
			});
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
	/**
	 * new password
	 */
	public function getNewPassword($id,$forgot_token)
	{
		return View::make('admin.new_password')->with('title','New Password');
	}
	public function postNewPassword($user_id,$forgot_token)
	{
		try {
			$password = Input::get('password');
			$this->users->NewPassword($user_id,$forgot_token,$password);
			return Redirect::to('admin');
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
	/**
	 * GET /admin/login
	 */
	public function getLogin()
	{
		if(Auth::check())
			return Redirect::to('admin/home');
		else
			return View::make('admin.login')->with('title','Login | Grabone');
	}
	/**
	 * POST /admin/login
	 */
	public function postLogin()
	{
		try {
			$user = $this->users->CheckLogin(Input::all());
			Auth::login($user);
			return Redirect::to('admin/home');
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
	/**
	 * Logout
	 */
	public function getLogout()
	{
		Auth::logout();
		return Redirect::to('admin/login');
	}
	/**
	 * GET /admin/dashboard
	 */
	public function getHome()
	{
		if(!Auth::check())
			return Redirect::to('admin/login');
		else
			return View::make('admin.home')->with('title','Home');
	}
	/**
	 * GET /neues-angebote
	 */
	public function getNeuesAngebote($id = null)
	{
		$deal = null;
		if($id){
			$vali  = ['id' => $id];
			$rules = ['id' => 'regex:/^[0-9]+$/'];
			if(Validator::make($vali,$rules)->fails())
				return ['status' => STR_STATUS_ERROR, 'message' => 'Validation Error'];
			else
				$deal = Deal::find($id);
				if(empty($deal)){
					return ['status' => STR_STATUS_ERROR, 'message' => 'Empty Deal'];
				}else{
					$deal->Location;
					$deal->State;
					$deal->Category;
					$deal->DealLocation;
					/**
					 * Format Time
					 */
					$deal->start_date = App::make('BaseController')->ConvertTime($deal->start_date,DATABASE_TO_VIEW);

					$deal->end_date = App::make('BaseController')->ConvertTime($deal->end_date,DATABASE_TO_VIEW);

				}

		}
		$user = Auth::user();
		$alldeal = $this->deal->All($this->auth->role_id);
		foreach ($alldeal as &$d) {
			$d->start_date = App::make('BaseController')->ConvertTime($d->start_date,DATABASE_TO_VIEW);
			$d->end_date = App::make('BaseController')->ConvertTime($d->end_date,DATABASE_TO_VIEW);
		}
		$data = array(
			'title'      => 'Neues Angebote',
			'locations'  => $this->locations->LocationState($user->role_id),
			'categories' => $this->categories->All(),
			'deal'       => $deal,
			'alldeal'    => $alldeal,
			);
		return View::make('admin.neues_angebote',$data);
	}
	/**
	 * POST /neues-angebote
	 */
	public function postNeuesAngebote()
	{
		// return Input::all();
		try {
			$data          = Input::get('deal');
			$location      = Input::get('location');
			$data['image'] = Input::get('image');
			extract(Input::all());
			$this->validator->ValidateDeal($data);
			/**
			 * Format Time
			 */
			$start_date = DateTime::createFromFormat('d/m/Y G:i:s', $data['start_date']);
			$start_date = $start_date->format('Y-m-d H:i:s');
			$end_date   = DateTime::createFromFormat('d/m/Y G:i:s', $data['end_date']);
			$end_date   = $end_date->format('Y-m-d H:i:s');
			$bis_date   = DateTime::createFromFormat('d/m/Y G:i:s', $data['bis_date']);
			$bis_date   = $bis_date->format('Y-m-d H:i:s');

			$deal = [
				'user_id'      => Auth::id(),
				'title'        => $data['title'],
				'image'        => $data['image'],
				'address'      => $data['address'],
				'postcode'     => $data['postcode'],
				'location_id'  => $data['location']['id'],
				// 'state_id'     => $data['state']['id'],
				// 'category_id'  => $data['category']['id'],
				// 'type'         => $data['type'],
				'phone'        => $data['phone'],
				'website'      => $data['website'],
				'note'         => $data['note'],
				'quantity'     => $data['quantity'],
				'start_date'   => $start_date,
				'end_date'     => $end_date,
				'bis_date'     => $bis_date,
				'sale_off'     => $data['sale_off'],
				'contact'      => $data['contact'],
				// 'return_bonus' => $data['return_bonus'],
				'preview'      => $data['preview'],
				'own_email'    => $data['own_email'],
				'description'  => $data['description'],
			];
			if(isset($deal_id)){
				// Deal::find($deal_id)->update($deal);
				Deal::where('id','=',$deal_id)->update($deal);
				$new_location = Deal::find($deal_id)->DealLocation;
			}else{
				$deal_id = Deal::insertGetId($deal);
				$new_location = new DealLocation();
			}
			/**
			 * Save deal location
			 */
			
				$new_location->deal_id = $deal_id;
				$new_location->lat     = $location['lat'];
				$new_location->lng     = $location['lng'];
			$new_location->save();
			/**
			 * Insert New Deal to SQL
			 */
			return ['status' => STR_STATUS_SUCCESS];
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
	
	/**
	 * Return Data
	 */
	public static function ReturnData($data){
		$response = Response::make($data);
		$response->header = 'Content-Type:application/json';
		return $response;
	}
	/**
	 * GET /admin/categories
	 */
	public function getCategories()
	{
		$data = [
			'title'      => 'Categories',
			'categories' => $this->categories->All('DESC'),
		];
		return View::make('admin.categories',$data);
	}
	/**
	 * GET /admin/location
	 */
	public function getLocation()
	{
		$data = [
			'title'      => 'Location',
			'locations'  => $this->location->LocationState(),
		];
		return View::make('admin.location',$data);
	}
	/**
	 * GET /admin/permission
	 */
	public function getAgent()
	{
		$agents = $this->users->Agent();
		foreach ($agents as $agent) {
			$agent->Location;
		}
		$data = [
			'title'      => 'Permission',
			'locations'  => $this->location->LocationState(),
			'agents'     => $agents,
		];
		return View::make('admin.agent',$data);
	}
	/**
	 * GET /admin/angebote
	 */
	public function getAngebote()
	{
		$user = Auth::user();
		$data = [
			'title' => 'Angebote',
			'deals' => $this->deal->All($user->role),
		];
		return View::make('admin.angebote',$data);
	}
	/**
	 * Admin Edit Deal /admin/
	 */
	public function getAngebotEdit()
	{
		$user = Auth::user();
		$data = [
			'title'      => 'Edit Angebot',
			'locations'  => $this->locations->LocationState($user->role),
			'categories' => $this->categories->All(),
			'type'       => 'edit',
		];
		return View::make('admin.neues_angebote',$data);
	}
	public function getManageUser()
	{
		$total_user = User::Where('role_id','=',5)->count();
		$page = App::make('BaseController')->page('page',20,$total_user);
		$data = [
			'title' => 'Manage User',
			'users' => $this->users->getAllUser($page->skip,$page->take),
			'pages' => $page->pages,
		];
		return View::make('admin.manage_user',$data);
	}
	public function getPromocode()
	{
		$data = [
			'title' => 'Promocode',
		];
		return View::make('admin.promocode',$data);
	}
	public function getNotification()
	{
		$data = [
			'locations'  => $this->locations->LocationState($this->auth->role_id),
			'title' => 'Push Notification',
		];
		return View::make('admin.notification',$data);
	}
	
}
?>