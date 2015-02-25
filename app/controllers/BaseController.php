<?php

class BaseController extends Controller {

	/**
	 * return page value
	 */
	public static function page($get_page = 'page',$number_item_per_page = 10,$total_item = 50){
		$page = new stdClass();
		if(!isset($_GET[$get_page])){
			$page->page = 1;
		}else{
			$rules = [
				'page' => 'regex:/^[0-9]+$/'
			];
			$valid = [
				'page' => $_GET[$get_page]
			];
			if(Validator::make($valid,$rules)->fails())
				$page->page = 1;
			else
				$page->page = $_GET[$get_page];
		}
		$total_page = ceil($total_item/$number_item_per_page);
		$page->skip = ($page->page - 1)*$number_item_per_page;
		$page->take = $number_item_per_page;
		$pages = [];
		for ($i=1; $i <= $total_page ; $i++) { 
			$page_link = new stdClass;
			$page_link->key = $i;
			$page_link->link = Request::url().'?'.$get_page.'='.$i;
			array_push($pages, $page_link);
		}
		$page->pages = $pages;
		return $page;
	}
	/**
	 * Return API error
	 */
	public static function ReturnError($e){
		return [
			'status' => STR_STATUS_ERROR,
			'error_code' => $e->getCode(),
			'message' => $e->getMessage(),
		];
	}
	/**
	 * Return Success
	 */
	public static function ReturnSuccess(){
		return ['status' => STR_STATUS_SUCCESS];
	}
	/**
	 * Retrun Data
	 */
	public static function ReturnData($data){
		$response = Response::make(['status' => STR_STATUS_SUCCESS,'response' => $data]);
		$response->header = 'Content-Type:application/json';
		return $response;
	}
	/**
	 * Format Deal Data
	 */
	public static function FormatDealData($deals){
		foreach ($deals as $deal) {
			$deal->image = asset($deal->image);
			$deal->DealLocation;
			$deal->Location;
			$deal->State;
			$deal->Category;
			$deal->DealRate;
		}
		return $deals;
	}
	/*
	* convert time, type= 1 = VIEW_TO_DATABASE: d/m/Y => Y-m-d, type = 2 DATABASE_TO_VIEW 
	*/
	public function ConvertTime($str_time,$type = VIEW_TO_DATABASE)
	{
		if($type == VIEW_TO_DATABASE){
			$time = DateTime::createFromFormat('d/m/Y G:i:s', $str_time);
			return $time->format('Y-m-d H:i:s');
		}else{
			$time = DateTime::createFromFormat('Y-m-d H:i:s', $str_time);
			return $time->format('d/m/Y G:i:s');
		}
	}
}
