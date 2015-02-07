<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('TableLanguagesSeeder');
		$this->call('TableOccupationsSeeder');
		$this->call('TableReportReasonSeeder');
	}

}
