<?php


class TableReportReasonSeeder extends Seeder {

    public function run()
    {
       	$reasons = [
       		["reason" => "He/She is spammer"],
       		["reason" => "I don't like him/her"],
        ];
       	foreach ($reasons as $reason) {
        	ReportReason::insert($reason);
        } 
    }

}