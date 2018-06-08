<?php

declare(strict_types=1);

use AdamDBurton\Mattermost\Types\Attachment;
use AdamDBurton\Mattermost\Types\Author;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Mock\Client;

use PHPUnit\Framework\TestCase;
use AdamDBurton\Mattermost\Mattermost;

final class MattermostTest extends TestCase
{
	/**
	 * @throws Exception
	 */
	public function testCanCreateMessage()
	{
		$mm = new Mattermost([
			'webhook' => 'http://my-mattermost-webhook.url'
		], new Client());

		$this->assertEquals([
			'text' => 'Hello',
			'channel' => 'test',
			'username' => 'Test Bot',
			'icon_url' => 'http://google.com/image.png',
			'attachments' => [],
			'type' => 'test',
			'props' => [
				'test' => 123,
				'test2' => 456
			]
		], $mm->message()
			->channel('test')
			->text('Hello')
			->username('Test Bot')
			->icon('http://google.com/image.png')
			->type('test')
			->props([
				'test' => 123,
				'test2' => 456
			])
			->getData()
		);
	}

	/**
	 * @throws Exception
	 * @throws \Http\Client\Exception
	 */
	public function testMessageMustContainTextOrAttachments()
	{
		$mm = new Mattermost([
			'webhook' => 'http://my-mattermost-webhook.url'
		], new Client());

		$this->expectException(Exception::class);

		$mm->message()->send();
	}

	/**
	 * @throws Exception
	 */
	public function testCanSendAttachment()
	{
		$mm = new Mattermost([
			'webhook' => 'http://my-mattermost-webhook.url'
		], new Client());

		$this->assertEquals([
			'attachments' => [
				[
					'fallback' => 'Attachment 1',
					'color' => '#D11014',
					'pretext' => 'This is some pretext',
					'text' => 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet.',
					'author_name' => 'Test User',
					'author_icon' => 'http://google.com/image.png',
					'fields' => []
				]
			]
		], $mm->message()
			->attach(function(Attachment $attachment)
			{
				$attachment
					->fallback('Attachment 1')
					->color('danger')
					->pretext('This is some pretext')
					->text('Integer posuere erat a ante venenatis dapibus posuere velit aliquet.')
					->author(function(Author $author)
					{
						$author
							->name('Test User')
							->icon('http://google.com/image.png');
					});
			})
			->getData()
		);
	}

	/**
	 * @throws \Http\Client\Exception
	 * @throws Exception
	 */
	public function testCanSendMessage()
	{
		$client = new Client();

		$mm = new Mattermost([
			'webhook' => 'http://my-mattermost-webhook.url'
		], $client);

		$client->addResponse(
			MessageFactoryDiscovery::find()->createResponse(
				200,
				null,
				[],
				'ok'
			)
		);

		$response = $mm->message()->text('test')->send();

		$this->assertEquals('ok', $response);

		//$this->assertSame($response, $message);
	}
}
