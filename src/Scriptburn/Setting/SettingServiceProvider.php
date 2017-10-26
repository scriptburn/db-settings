<?php

namespace Scriptburn\Setting;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
 		$this->loadMigrationsFrom(  __DIR__.'/../../migrations' );

	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */

	public function register()
	{
		return $this->app->singleton('Scriptburn\Setting\Setting', function ($app)
		{
			return new Setting($app->db);
		});

	}

}
