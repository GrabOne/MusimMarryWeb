<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealLocation extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('deal_location', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('deal_id')->unsigned();
			$table->foreign('deal_id')->references('id')->on('deals')->onDelete('cascade');
			$table->string('lat',10);
			$table->string('lng',10);
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
		Schema::drop('deal_location');
	}

}
