<?php

namespace AdamDBurton\Mattermost\Laravel;

use AdamDBurton\Mattermost\Mattermost;
use Http\Discovery\HttpClientDiscovery;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
	protected $defer = false;

	public function register()
	{
		$configPath = __DIR__ . '/../../config/mattermost-webhook.php';
		$this->mergeConfigFrom($configPath, 'mattermost-webhook');

		$this->app->singleton(Mattermost::class, function ($app)
		{
			return new Mattermost($app['config']->get('mattermost-webhook'), HttpClientDiscovery::find());
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