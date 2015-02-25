<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealRate extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('deal_rate', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('deal_id')->unsigned();
			$table->foreign('deal_id')->references('id')->on('deals');
			$table->integer('total_rate');
			$table->integer('number_star');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('deal_rate');
	}

}
