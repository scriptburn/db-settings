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
		$this->loadMigrationsFrom(__DIR__.'/migrations');

	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */

	public function register()
	{
		$this->app->singleton(Settings::class, function ($app)
		{
			return new Settings($app->db);
		});
	}

}
