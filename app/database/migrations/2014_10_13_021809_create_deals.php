<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeals extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('deals', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->string('title',500);
			$table->string('image');
			$table->string('address',160);
			$table->string('postcode',10);
			$table->integer('location_id')->unsigned();
			$table->foreign('location_id')->references('id')->on('locations');
			$table->integer('state_id')->unsigned();
			$table->foreign('state_id')->references('id')->on('states');
			$table->integer('category_id')->unsigned();
			$table->foreign('category_id')->references('id')->on('categories');
			$table->string('phone',16);
			$table->string('website',40);
			$table->string('note',100);
			$table->string('price');
			$table->integer('quantity');
			$table->string('start_date',24);
			$table->string('end_date',24);
			$table->string('bis_date',24);
			$table->string('refresh',10);
			$table->string('usages',10);
			$table->string('sale_off',5);
			$table->string('contact',40);
			$table->string('return_bonus',10);
			$table->string('preview');
			$table->string('own_email',40);
			$table->string('description');
			$table->text('time_sensitive');
			$table->string('time_sensitive_header');
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
		Schema::drop('deals');
	}

}
