<?php
interface ReportRepo {
	public function ReportUser($user,$user_report_id,$reason_id);
	public function getReportReason();
}
?>