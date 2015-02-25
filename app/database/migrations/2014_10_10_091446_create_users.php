<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username',30)->unique();
			$table->index('username');
			$table->string('email',40)->unique();
			$table->index('email');
			$table->string('facebook_id');
			$table->string('facebook_authentication_token');
			$table->string('password',64);
			$table->string('balance',20)->default(0);
			$table->string('promocode',10)->unique();
			$table->index('promocode');
			$table->smallInteger('role_id');
			$table->string('remember_token',100);
			$table->string('forgot_token',32);
			$table->boolean('active');
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
		Schema::drop('users');
	}

}
