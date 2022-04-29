<?php

namespace NllLib\Tests;

use NllLib\ApiCache;
use PHPUnit\Framework\TestCase;

class ApiCacheTest extends TestCase
{
	public function testKeyCache()
	{
		$cache	= ApiCache::getInstance();

		/*
		** Check if key cache can be requested if not exist.
		*/
		$cache->keyDelete();
		$cache_key	= $cache->keyRetrieve();

		$this->assertSame(Null, $cache_key);

		/*
		** Check if it's possible to strore key into cache file.
		*/
		$key		= "example_64763d626330a485fe2602a38e17a91fa376fd01ad";
		$cache_key	= Null;
		$cache->keySave($key);
		$cache_key = $cache->keyRetrieve();

		$this->assertSame($key, $cache_key);
	}
}
