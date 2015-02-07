<?php
class DbBlockRepo extends \Exception implements BlockRepo{
	public function __construct($message = '',$error_code = null)
	{

	}
	public function BlockUser($user,$user_block_id,$type){
		if($type == 1){
			//block 30 day
			$block = $user->block_30_day;
			$date = date('Y-m-d');
			$date = new DateTime($date);
			$date->modify('+30 day');
			$block_add = [
				'_id' => $user_block_id,
				'from' => date('Y-m-d'),
				'to' => $date->format('Y-m-d'),
			];
			if(isset($block)){
				array_push($block, $block_add);
			}else{
				$block = [$block_add];
			}
			$user->block_30_day = $block;
			$user->save();
		}else{
			// block permanently
			$block = $user->block_permanently;
			if(isset($block)){
				if(in_array($user_block_id,$block))
					throw new Exception(STR_ERROR_USER_BLOCKED, 10);
				else
					array_push($block, $block_add);
			}else{
				$block = [$user_block_id];
			}
			$user->block_permanently = $block;
			$user->save();
		}
	}
}
?>