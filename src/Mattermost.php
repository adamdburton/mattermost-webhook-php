<?php

namespace AdamDBurton\Mattermost;

use AdamDBurton\Mattermost\Types\Message;

use Http\Client\Exception;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\MessageFactory;

class Mattermost
{
	protected $config;
	protected $httpClient;
	protected $httpClientFactory;

	/**
	 * Mattermost constructor.
	 * @param array $config
	 * @param HttpClient $httpClient
	 * @param MessageFactory $httpClientFactory
	 * @throws \Exception
	 */
	public function __construct($config, $httpClient = null, $httpClientFactory = null)
	{
		if(!isset($config['webhook']))
		{
			throw new \Exception('Webhook is required.');
		}

		$this->config = $config;
		$this->httpClient = $httpClient ?: HttpClientDiscovery::find();
		$this->httpClientFactory = $httpClientFactory ?: MessageFactoryDiscovery::find();
	}

	/**
	 * @return Message
	 */
	public function message()
	{
		return new Message($this);
	}

	public function send($data, $webhook = null)
	{
		$url = $webhook ?: $this->config['webhook'];

		$request = $this->httpClientFactory->createRequest('POST', $url, [], json_encode($data));

		try
		{
			$response = $this->httpClient
				->sendRequest($request)
				->getBody()
				->getContents();
		}
		catch(\Exception $e)
		{
			return false;
		}
		catch(Exception $e)
		{
			return false;
		}

		return $response == 'ok' ? true : json_decode($response, true);
	}
}