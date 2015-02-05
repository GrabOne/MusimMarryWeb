<?php


class TableLanguagesSeeder extends Seeder {

    public function run()
    {
       	$languages = [
       		["name" => "english"],
       		["name" => "german"],
       ];
       	foreach ($languages as $language) {
        	Language::insert($language);
        } 
    }

}