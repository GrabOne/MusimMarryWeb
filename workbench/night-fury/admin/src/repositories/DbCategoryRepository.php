<?php
define('STR_ERROR_VALIDATE_CATEGORY','Error validate category');
define('STR_ERROR_CATEGORY_NOT_FOUND','Category not found');
define('STR_ERROR_CATEGORY_LOGIN','Login Error');
define('STR_ERROR_CATEGORY_EXIST','Category already exist');
class DbCategoryRepository extends Exception implements CategoryRepository{
	public function __construct($message = '',$error_code = null){

	}
	/**
	 * category select
	 */
	protected $category_select_array = ['id','name'];
	public function All($orderBy = 'ASC'){
		return Categories::select($this->category_select_array)->orderBy('id',$orderBy)->get();
	}
	/**
	 * When $type == 1 => return ID
	 */
	public function Insert($category,$type = null){
		$vali  = ['category' => $category];
		$rules = ['category' => ['required','max:50']];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_VALIDATE_CATEGORY, 1);
		else
			$count = Categories::where('name','=',$category)->count();
			if($count > 0)
				throw new Exception(STR_ERROR_CATEGORY_EXIST, 2);
			elseif($type == 1)
				return Categories::insertGetId(['name'=>$category]);
			else
				Categories::insert(['name'=>$category]);
			
			
	}
	/**
	 * Remove Category
	 */
	public function Delete($category_id){
		$vali = [
			'category_id'    => $category_id,
		];
		$rules = [
			'category_id'    => ['required','regex:/^[0-9]+$/']
		];
		if(Validator::make($vali,$rules)->fails())
			throw new Exception(STR_ERROR_VALIDATE_CATEGORY, 1);
		elseif(!Auth::check())
			throw new Exception(STR_ERROR_CATEGORY_LOGIN, 2);			
		else
			$category = Categories::find($category_id);
			if(empty($category))
				throw new Exception(STR_ERROR_CATEGORY_NOT_FOUND, 3);
			else
				$category->delete();
	}
}
?>