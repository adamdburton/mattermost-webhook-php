<?php

namespace AdamDBurton\Mattermost\Laravel;

use AdamDBurton\Mattermost\Mattermost;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
	protected $defer = false;

	public function register()
	{
		$configPath = __DIR__ . '/../../config/mattermost-webhook.php';
		$this->mergeConfigFrom($configPath, 'mattermost-webhook');

		$this->app->singleton('mattermost', function ($app)
		{
			return new Mattermost($app['config']->get('mattermost-webhook'));
		});
	}

	public function boot()
	{
		$configPath = __DIR__ . '/../../config/mattermost-webhook.php';
		$this->publishes([ $configPath => config_path('mattermost-webhook.php') ], 'config');
	}

	public function provides()
	{
		return [
			Mattermost::class
		];
	}

}