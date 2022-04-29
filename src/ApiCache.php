<?php

namespace NllLib;

use \DateTime;

use phpFastCache\CacheManager;
use phpFastCache\Config\ConfigurationOption;

use NllLib\Utils\Path;

class ApiCache
{

	private static $INSTANCE	= null;

	private static $DRIVER		= "Files";

	private static $CACHE_PATH	= "../cache";

	protected $cache;

	private function __construct()
	{
		$path = new Path(__FILE__);
		CacheManager::setDefaultConfig([
			'path' => $path->absolut(self::$CACHE_PATH),
			]);
		$this->cache = CacheManager::getInstance();
	}

	public static function getInstance()
	{
		if (!self::$INSTANCE)
			self::$INSTANCE = new ApiCache();
		return self::$INSTANCE;
	}

	public function keyDelete()
	{
		$cache = $this->cache->getItem("api-key");

		if ($cache->isHit())
		{
			$this->cache->deleteItem("api-key");
			return True;
		}
		return False;
	}

	public function keyRetrieve()
	{
		$cache = $this->cache->getItem("api-key");

		if ($cache->isHit())
			return $cache->get();
		return Null;
	}

	public function keySave($key)
	{
		$cache = $this->cache->getItem("api-key");

		$cache->set($key)->expiresAt(new DateTime("@9999999999"));
		$this->cache->save($cache);
	}
}
