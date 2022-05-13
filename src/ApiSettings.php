<?php

namespace NllLib;

use NllLib\ApiCache;

class ApiSettings
{

	protected $timeout;

	protected $url;

	public function __construct()
	{
		$this->url		= "http://127.0.0.1:8000/";
		$this->timeout	= '2.0';
	}

	public function getTimeout()
	{
		return $this->timeout;
	}

	public function getUrl()
	{
		return $this->url;
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
}
