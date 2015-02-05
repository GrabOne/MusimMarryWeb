<?php


class TableOccupationsSeeder extends Seeder {

    public function run()
    {
       	$occupations = [
       		["name" => "teacher"],
       		["name" => "doctor"],
       		["name" => "student"],
       ];
       	foreach ($occupations as $occupation) {
        	Occupation::insert($occupation);
        } 
    }

}