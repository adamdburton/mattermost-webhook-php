<?php

namespace AdamDBurton\Mattermost\Types;

use AdamDBurton\Mattermost\Mattermost;

class Message
{
	protected $mattermost;
	protected $webhook;

	protected $data = [];
	protected $attachments = [];

	/**
	 * Message constructor.
	 * @param Mattermost $mattermost
	 */
	public function __construct(Mattermost $mattermost)
	{
		$this->mattermost = $mattermost;
	}

	/**
	 * @param $webhook
	 * @return $this
	 */
	public function webhook($webhook)
	{
		$this->webhook = $webhook;

		return $this;
	}

	/**
	 * @param $text
	 * @return $this
	 */
	public function text($text)
	{
		$this->data['text'] = $text;

		return $this;
	}

	/**
	 * @param $channel
	 * @return $this
	 */
	public function channel($channel)
	{
		$this->data['channel'] = $channel;

		return $this;
	}

	/**
	 * @param $username
	 * @return $this
	 */
	public function username($username)
	{
		$this->data['username'] = $username;

		return $this;
	}

	/**
	 * @param $icon
	 * @return $this
	 */
	public function icon($icon)
	{
		$this->data['icon_url'] = $icon;

		return $this;
	}

	/**
	 * @param $type
	 * @return $this
	 */
	public function type($type)
	{
		$this->data['type'] = $type;

		return $this;
	}

	/**
	 * @param $props
	 * @return $this
	 */
	public function props($props)
	{
		$this->data['props'] = $props;

		return $this;
	}

	/**
	 * @param $callback
	 * @return $this
	 */
	public function attach($callback)
	{
		$attachment = new Attachment;

		$callback($attachment);

		$this->attachments[] = $attachment->getData();

		return $this;
	}

	/**
	 * @return array
	 */
	public function getData()
	{
		return array_merge($this->data, [ 'attachments' => $this->attachments ]);
	}

	/**
	 * @throws \Http\Client\Exception
	 * @throws \Exception
	 */
	public function send()
	{
		$data = $this->getData();

		if((!isset($data['text']) || !strlen($data['text'])) && !count($data['attachments']))
		{
			throw new \Exception('Message must contain either text or attachment(s) to be sent.');
		}

		return $this->mattermost->send($data, $this->webhook);
	}
}