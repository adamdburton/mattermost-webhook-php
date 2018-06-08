<?php

namespace AdamDBurton\Mattermost\Types;

use Closure;

class Attachment
{
	protected $data = [];
	protected $fields = [];
	protected $actions = [];

	public function fallback($fallback)
	{
		$this->data['fallback'] = $fallback;

		return $this;
	}

	public function color($color)
	{
		switch($color)
		{
			case 'good':
				$color = '#3DA253';
				break;
			case 'warning':
				$color = '#DC9D3D';
				break;
			case 'danger':
				$color = '#D11014';
				break;
		}

		$this->data['color'] = $color;

		return $this;
	}

	public function pretext($pretext)
	{
		$this->data['pretext'] = $pretext;

		return $this;
	}

	public function text($text)
	{
		$this->data['text'] = $text;

		return $this;
	}

	public function author($callback)
	{
		$author = new Author;

		$callback($author);

		$this->data = array_merge($this->data, $author->getData());

		return $this;
	}

	public function title($callback)
	{
		if($callback instanceof Closure)
		{
			$this->data['title'] = $text;

			return $this;
		}
		else
		{
			$title = new Title;

			$callback($title);

			$this->data = array_merge($this->data, $title->getData());
		}

		return $this;
	}

	public function field($callback)
	{
		$field = new Field;

		$callback($field);

		$this->fields[] = $field->getData();

		return $this;
	}

	public function image($url)
	{
		$this->data['image_url'] = $url;

		return $this;
	}

	public function thumbnail($url)
	{
		$this->data['thumb_url'] = $url;

		return $this;
	}

	public function action($callback)
	{
		$action = new Action;

		$callback($action);

		$this->actions[] = $action->getData();

		return $this;
	}

	// Future compatibility

	public function footer($callback)
	{
		$footer = new Footer;

		$callback($footer);

		$this->data = array_merge($this->data, $footer->getData());

		return $this;
	}

	public function getData()
	{
		return array_merge($this->data, [ 'fields' => $this->fields ]);
	}
}