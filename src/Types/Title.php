<?php

namespace AdamDBurton\Mattermost\Types;

class Title
{
	protected $data = [];

	public function title($title)
	{
		$this->data['title'] = $title;

		return $this;
	}

	public function link($url)
	{
		$this->data['title_link'] = $url;

		return $this;
	}

	public function getData()
	{
		return $this->data;
	}
}