<?php


class CategoriesTableSeeder extends Seeder {

	public function run()
	{
		$categories = [
			['name' =>'Beauty'],
			['name' =>'Essen'],
			['name' =>'Andere'],
			['name' =>'Nachtleben']
			];
		foreach ($categories as $category) {
			Categories::insert($category);
		}
	}

}