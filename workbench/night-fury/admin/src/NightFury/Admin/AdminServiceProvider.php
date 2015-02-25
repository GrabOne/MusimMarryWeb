<?php namespace NightFury\Admin;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider {

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
		$this->package('night-fury/admin');
		include __DIR__ . "/routes.php";
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('UserRepository','DbUserRepository');
		$this->app->bind('LocationRepository','DbLocationRepository');
		$this->app->bind('CategoryRepository','DbCategoryRepository');
		$this->app->bind('LocationRepository','DbLocationRepository');
		$this->app->bind('DealRepository','DbDealRepository');
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
