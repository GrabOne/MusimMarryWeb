<?php


class LocationTableSeeder extends Seeder {

	public function run()
	{
		$locations = [
			['location' => 'Hamburg'],
			['location' => 'Hannover'],
			['location' => 'Paderborn'],
			['location' => 'Dortmund'],
			['location' => 'Frankfurt'],
			['location' => 'Stuttgart'],
		];
		foreach($locations as $location){
			Location::insert($location);
		}
	}

}