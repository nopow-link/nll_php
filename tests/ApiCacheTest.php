<?php

namespace NllLib\Tests;

use NllLib\ApiCache;
use PHPUnit\Framework\TestCase;

class ApiCacheTest extends TestCase
{
	public function testKeyCache()
	{
		$cache	= ApiCache::getInstance();
		$cache->keyDelete();

		/*
		** Check if key cache can be requested if not exist.
		*/
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

	public function testSlugCache()
	{
		$slug	= '/test/';
		$cache	= ApiCache::getInstance();
		$cache->linkDelete($slug);

		/*
		** Check if slug can be requested if not exists
		*/
		$cache_data	= $cache->linkRetrieve($slug);

		$this->assertSame(Null, $cache_data);

		/*
		** Check if it's possible to store link information into cache file.
		*/
		$slug		= '/test/';
		$data		= [
				json_encode([
					"pk"			=> 1,
					"source"		=> "<p>Test</p>",
					"occurence"		=> 1,
					"substitute"	=> "<p><a href=\"https://test.com/\" rel=\"sponsored\">Test</a></p>."
					])
			];

		$cache->linkSave($slug, $data);
		$cache_data	= $cache->linkRetrieve($slug);

		$this->assertSame($data, $cache_data);
	}
}
