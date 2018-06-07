<?php

namespace AdamDBurton\Mattermost;

use AdamDBurton\Mattermost\Types\Message;

use Http\Client\HttpClient;
use Http\Discovery\MessageFactoryDiscovery;

class Mattermost
{
	protected $config;
	protected $httpClient;
	protected $httpClientFactory;

	/**
	 * Mattermost constructor.
	 * @param array $config
	 * @param HttpClient $httpClient
	 * @throws \Exception
	 */
	public function __construct($config, HttpClient $httpClient)
	{
		if(!isset($config['webhook']))
		{
			throw new \Exception('Webhook is required');
		}

		$this->config = $config;
		$this->httpClient = $httpClient;
		$this->httpClientFactory = MessageFactoryDiscovery::find();
	}

	/**
	 * @return Message
	 */
	public function message()
	{
		return new Message($this);
	}

	/**
	 * @param $data
	 * @param null $webhook
	 * @return mixed|string
	 * @throws \Http\Client\Exception
	 */
	public function send($data, $webhook = null)
	{
		$url = $webhook ?: $this->config['webhook'];

		$request = $this->httpClientFactory->createRequest('POST', $url, [
				'form_params' => [
					'payload' => json_encode($data)
				]
			]
		);

		$response = $this->httpClient->sendRequest($request)->getBody()->getContents();

		return $response == 'ok' ? $response : json_decode($response, true);
	}
}