<?php

namespace AdamDBurton\Mattermost\Types;

class Action
{
	protected $data = [];

	public function name($name)
	{
		$this->data['name'] = $name;

		return $this;
	}

	public function integration($callback)
	{
		$integration = new Integration;

		$callback($integration);

		$this->data['integration'] = $integration->getData();

		return $this;
	}

	public function getData()
	{
		return $this->data;
	}
}