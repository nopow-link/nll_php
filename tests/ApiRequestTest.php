<?php

namespace NllLib\Tests;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

use NllLib\ApiCache;
use NllLib\ApiRequest;
use NllLib\Exception\NllLibCertifyException;


class ApiRequestTest extends TestCase
{
	private function certifyResponseHandlerStack()
	{
		return new MockHandler([
			new Response(
				200,
				$headers 	= ['Content-Type' => 'application/json'],
				$body		= ''
				),
			new Response(
				404,
				$headers	= ['Content-Type' => 'application/json'],
				$body		= ''
				)
		]);
	}

	public function testCertifyRequest()
	{
		/*
		** Clear cache befor test.
		*/
		$cache			= ApiCache::getInstance();
		$cache->keyDelete();

		/*
		** This test it's for testing the instanciation of the API request with
		** standard call to the Nopow-Link API.
		*/
		$requests	= new ApiRequest();
		$key		= "invalid_64763d626330a485fe2602a38e17a91fa376fd01ad";

		try
		{
			$result 	= $requests->certify($key);
		}
		catch (NllLibCertifyException $e)
		{
			$result		= False;
		}
		$this->assertSame(False, $result);



		$requests		= new ApiRequest(
			$handlerStack = HandlerStack::create(
				$this->certifyResponseHandlerStack()
				));
		$valid_key	 	= "valid_64763d626330a485fe2602a38e17a91fa376fd01ad";
		$invalid_key 	= "invalid_64763d626330a485fe2602a38e17a91fa376fd01ad";

		/*
		** This test is for testing if the key is correctly strored by the cache
		** if the certify request succeed.
		*/
		try
		{
			$cache->keySave($valid_key);
			$result 	= $requests->certify($valid_key);
		}
		catch (NllLibCertifyException $e)
		{
			$result		= False;
		}
		$this->assertSame(True, $result);
		$this->assertSame($valid_key, $cache->keyRetrieve());

		/*
		** This test is for testing the that no cache is stored with invalide
		** key.
		*/
		try
		{
			$result 	= $requests->certify($invalid_key);
		}
		catch (NllLibCertifyException $e)
		{
			$result		= False;
		}
		$this->assertSame(False, $result);
		$this->assertSame($valid_key, $cache->keyRetrieve());
	}

	public static function JSON_COLLECT_0()
	{
		return json_encode([
			[
				"pk"			=> 1,
				"source"		=> "<p>Test</p>",
				"occurence"		=> 1,
				"substitute"	=> "<p><a href=\"https://test.com/\" rel=\"sponsored\">Test</a></p>."
				]
			]);
	}

	private function collectResponseHandlerStack()
	{
		return new MockHandler([
			new Response(
				200,
				$headers	= ['Content-Type' => 'application/json'],
				$body 		= ApiRequestTest::JSON_COLLECT_0()
				),
			new Response(
				404,
				$headers	= ['Content-Type' => 'application/json'],
				$body		= ''
				)
			]);
	}

	public function testCollectRequest()
	{
		$requests	= new ApiRequest();
		$slug		= "/test/";

		/*
		** Clear cache after test.
		*/
		$cache			= ApiCache::getInstance();
		$cache->keyDelete();
		$cache->linkDelete($slug);

		/*
		** This test doesn't send request. This test validate that no error are
		** throwed if user doesn't certify is pllugin yet. (There is no key in
		** cache).
		*/
		$result		= $requests->collect($slug);
		$this->assertSame([], $result);



		$requests		= new ApiRequest(
			$handlerStack = HandlerStack::create(
				$this->collectResponseHandlerStack()
				));
		$valid_key	 	= "valid_64763d626330a485fe2602a38e17a91fa376fd01ad";
		$cache->keySave($valid_key);

		/*
		** This test check if the api collect request work correctly and check
		** if the data collected from the slug is correctly stored into cache.
		*/
		try
		{
			$result		= $requests->collect($slug);
		}
		catch (NllLibCollectException $e)
		{
			$result 	= False;
		}

		$this->assertSame(
			ApiRequestTest::JSON_COLLECT_0(),
			json_encode($result)
			);
		$this->assertSame(
			ApiRequestTest::JSON_COLLECT_0(),
			json_encode($requests->get_cache()->linkRetrieve($slug))
			);

		/*
		** This test check if the api collect function select file into cache
		** rather than send request to api.
		*/
		try
		{
			$result		= $requests->collect($slug);
		}
		catch (NllLibCollectException $e)
		{
			$result 	= False;
		}
		$this->assertSame(
			ApiRequestTest::JSON_COLLECT_0(),
			json_encode($result)
			);
	}
}
