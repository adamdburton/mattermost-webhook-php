<?php

namespace AdamDBurton\Mattermost\Types;

class Footer
{
	protected $data = [];

	public function footer($footer)
	{
		$this->data['footer'] = $footer;

		return $this;
	}

	public function icon($url)
	{
		$this->data['footer_icon'] = $url;

		return $this;
	}

	public function timestamp($timestamp)
	{
		$this->data['ts'] = $timestamp;

		return $this;
	}

	public function getData()
	{
		return $this->data;
	}
}