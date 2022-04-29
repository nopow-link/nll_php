<?php

namespace NllLib;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException ;
use Psr7\Message as Psr7Message;

use NllLib\ApiCache;
use NllLib\ApiException;
use NllLib\ApiSettings;
use NllLib\ApiIdentifier;
use NllLib\Exception\NllLibCertifyException;
use NllLib\Utils\Url;

class ApiRequest
{

	protected $cache;

	protected $client;

	protected $settings;

	public function __construct() {
		$this->settings	= new ApiSettings();
		$this->cache	= ApiCache::getInstance();
		$this->client	= new Client([
			'base_uri'	=> $this->settings->getUrl(),
			'timeout'	=> $this->settings->getTimeout()
			]);
	}

	public function certify($key)
	{
		try
		{
			$response = $this->client->request(
				'GET',
				ApiIdentifier::certify($key)
				);
			return $response;
		}
		catch (TransferException $e) {throw new NllLibCertifyException($e);}
	}
}
