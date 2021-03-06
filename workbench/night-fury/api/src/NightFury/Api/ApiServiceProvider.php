<?php namespace NightFury\Api;

use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('night-fury/api');
		include __DIR__ . "/routes.php";
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('DealApiRepository','DbDealApiRepository');
		$this->app->bind('PromocodeApiRepository','DbPromocodeApiRepository');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
