<?php

namespace AdamDBurton\Mattermost\Types;

class Integration
{
	protected $data = [];

	public function url($url)
	{
		$this->data['url'] = $url;

		return $this;
	}

	public function context($data)
	{
		$this->data['context'] = $data;

		return $this;
	}

	public function getData()
	{
		return $this->data;
	}
}