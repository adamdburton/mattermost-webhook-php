<?php

namespace AdamDBurton\Mattermost\Laravel;

use AdamDBurton\Mattermost\Mattermost;

class Facade extends \Illuminate\Support\Facades\Facade
{
	protected static function getFacadeAccessor()
	{
		return Mattermost::class;
	}
}