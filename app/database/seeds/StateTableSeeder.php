<?php

// Composer: "fzaninotto/faker": "v1.3.0"
// use Faker\Factory as Faker;

class StateTableSeeder extends Seeder {

	public function run()
	{
		$states = [
			['state' => 'State demo 1','location_id'=> 1],
			['state' => 'State demo 2','location_id'=> 1],
			['state' => 'State demo 3','location_id'=> 1],
			['state' => 'State demo 4','location_id'=> 1],
			['state' => 'State demo 5','location_id'=> 2],
			['state' => 'State demo 6','location_id'=> 2],
			['state' => 'State demo 7','location_id'=> 3],
			['state' => 'State demo 8','location_id'=> 4],
			['state' => 'State demo 9','location_id'=> 4],
			['state' => 'State demo 10','location_id'=> 4],
		];
		foreach ($states as $state) {
			State::insert($state);
		}
	}

}