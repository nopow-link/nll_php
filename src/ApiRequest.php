<?php

namespace NllLib;

use NllLib\ApiCache;
use NllLib\ApiSettings;
use Illuminate\Support\Facades\Http;

class ApiRequest
{

	protected $cache;

	protected $settings;

	public function __construct() {
		$this->cache	= new ApiCache()
		$this->settings	= new ApiSettings()
	}

}
