<?php
class DbReportRepo extends \Exception implements ReportRepo{
	public function __construct($message = '',$error_code = null)
	{

	}
	public function ReportUser($user,$user_report_id,$reason_id)
	{
		$user_report = User::find($user_report_id);
		if(isset($reason_id)){
			$reason      = ReportReason::find($reason_id);
		}else{
			$reason      = ReportReason::get();
			$reason      = $reason[0];
		}
		if(empty($user))
			throw new Exception(STR_ERROR_USER_NOT_FOUND, 8);
		elseif(empty($reason))
			throw new Exception(STR_ERROR_REASON_NOT_FOUND, 9);
		else
			$report = Report::where('user_report_id','=',$user_report_id);
			if($report->count() == 0){
				$user_report = [
					"_id"      => $user->_id,
					"username" => $user->username,
					"nickname" => $user->nickname,
					"avatar"   => $user->avatar,
				];
				$reason_report = [
					"_id"    => $reason->_id,
					"reason" => $reason->reason,
				]; 
				$report = new Report();
				$report->user_report = [$user_report];
				$report->user_report_id = $user_report_id;
				$report->report = [$reason_report];
				$report->save();
			}else{
				$report = $report->first();
				$user_report = $report->user_report;
				$user_report_add = [
					"_id"      => $user->_id,
					"username" => $user->username,
					"nickname" => $user->nickname,
					"avatar"   => $user->avatar,
				];
				array_push($user_report,$user_report_add);
				$user->user_report = $user_report;
				$reason_report = $report->report;
				$reason_report_add = [
					"_id"    => $reason->_id,
					"reason" => $reason->reason,
				]; 
				array_push($reason_report, $reason_report_add);
				$report->report = $reason_report;
				$report->save();
			}
			return true;
	}
	/*
	* get report reason
	*/
	public function getReportReason()
	{
		return ReportReason::get();
	}
}
?>