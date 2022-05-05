<?php

namespace NllLib\Tests;

use PHPUnit\Framework\TestCase;

use NllLib\ApiCache;
use NllLib\ApiRequest;
use NllLib\Exception\NllLibCertifyException;


class ApiRequestTest extends TestCase
{
	public function testCertifyRequest()
	{
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
	}

	public function testCollectRequest()
	{
		$requests	= new ApiRequest();
		$slug		= "/test/";

		$cache		= ApiCache::getInstance();
		$cache->keyDelete();
		$result		= $requests->collect($slug);
		$this->assertSame([], $result);
	}
}
