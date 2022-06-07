<?php

namespace NllLib;

use \DateTime;
use \DateInterval;

use phpFastCache\CacheManager;
use phpFastCache\Config\ConfigurationOption;

use NllLib\ApiSettings;

class ApiCache
{

	private static $INSTANCE	= null;

	private static $DRIVER		= "Files";

	protected $cache;

	protected $settings;

	private function __construct()
	{
		$this->settings = ApiSettings::getInstance();
		CacheManager::setDefaultConfig([
			'path' => $this->settings->getCacheFolder(),
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

	public function keySave($key, $delay = Null)
	{
		$cache = $this->cache->getItem("api-key");

		if ($delay)
		{
			$expire = new DateTime();
			$delay	= new DateInterval($delay);
			$expire->add($delay);
		}
		else
		{
			$expire = new DateTime("2037-01-01");
		}
		$cache->set($key)->expiresAt($expire);
		$this->cache->save($cache);
	}

	public function linkDelete($slug)
	{
		$cache = $this->cache->getItem($slug);

		if ($cache->isHit())
		{
			$this->cache->deleteItem($slug);
			return True;
		}
		return False;
	}

	public function linkRetrieve($slug)
	{
		$cache = $this->cache->getItem($slug);

		if ($cache->isHit())
			return $cache->get();
		return Null;
	}

	public function linkSave($slug, $data)
	{
		$cache = $this->cache->getItem($slug);

		$date	= new DateTime();
		$date->add(new DateInterval('PT1H'));
		$cache->set($data)->expiresAt($date);
		$this->cache->save($cache);
	}
}
