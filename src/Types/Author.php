<?php

namespace AdamDBurton\Mattermost\Types;

class Author
{
	protected $data = [];

	public function name($name)
	{
		$this->data['author_name'] = $name;

		return $this;
	}

	public function link($url)
	{
		$this->data['author_link'] = $url;

		return $this;
	}

	public function icon($url)
	{
		$this->data['author_icon'] = $url;

		return $this;
	}

	public function getData()
	{
		return $this->data;
	}
}