<?php

namespace AdamDBurton\Mattermost\Types;

class Field
{
	protected $data = [];

	public function title($title)
	{
		$this->data['title'] = $title;

		return $this;
	}

	public function value($value)
	{
		$this->data['value'] = $value;

		return $this;
	}

	public function short($bool)
	{
		$this->data['short'] = (bool) $bool;

		return $this;
	}

	public function getData()
	{
		return $this->data;
	}
}