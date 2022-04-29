<?php

namespace NllLib;

use NllLib\ApiCache;

class ApiSettings
{

	protected $cache;

	protected $key;

	protected $url;

	public function __construct()
	{
		$this->cache	= new ApiCache()
		$this->url		= "https://www.nopow-link.com";
		$this->key		= $this->cache->key_retrieve()
	}

	public function get_key()
	{
		return $this->key;
	}

	public function get_url()
	{
		return $this->url;
	}

	protected function set_url(string $url)
	{
		$this->url = $url;
		return $this;
	}

	protected function set_key(string $key)
	{
		$this->key = $key;
		return $this;
	}
}
