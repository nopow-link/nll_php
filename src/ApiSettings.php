<?php

namespace NllLib;

use NllLib\Utils\Path;

class ApiSettings
{
	private static $INSTANCE	= null;

	private static $CACHE_PATH	= "../cache";

	protected $timeout;

	protected $url;

	private function __construct()
	{
		$this->url				= "https://nopow-link.com/";
		$this->timeout			= '2.0';

		$path = new Path(__FILE__);
		$this->cache_folder		= $path->absolut(self::$CACHE_PATH);
	}

	public static function getInstance()
	{
		if (!self::$INSTANCE)
			self::$INSTANCE = new ApiSettings();
		return self::$INSTANCE;
	}

	public function getTimeout()
	{
		return $this->timeout;
	}

	public function getUrl()
	{
		return $this->url;
	}

	public function getCacheFolder()
	{
		return $this->cache_folder;
	}

	public function setUrl(string $url)
	{
		$this->url = $url;
		return $this;
	}

	public function setTimeout(string $timeout)
	{
		$this->time	= $timeout;
		return $this;
	}

	public function setCacheFolder(string $folder)
	{
		$this->cache_folder = $folder;
		return $this;
	}
}
