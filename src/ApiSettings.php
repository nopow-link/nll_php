<?php

namespace NllLib;

use NllLib\ApiCache;

class ApiSettings
{

	protected $cache;

	protected $key;

	protected $timeout;

	protected $url;

	public function __construct()
	{
		$this->cache	= ApiCache::getInstance();
		$this->key		= $this->cache->keyRetrieve();
		$this->timeout	= '2.0';
		$this->url		= "http://127.0.0.1:8000/";
	}

	public function getTimeout()
	{
		return $this->timeout;
	}

	public function getKey()
	{
		return $this->key;
	}

	public function getUrl()
	{
		return $this->url;
	}

	protected function setUrl(string $url)
	{
		$this->url = $url;
		return $this;
	}

	protected function setKey(string $key)
	{
		$this->key = $key;
		return $this;
	}

	public function setTimeout(string $timeout)
	{
		$this->time	= $timeout;
		return $this;
	}
}
