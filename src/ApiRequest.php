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
use NllLib\Exception\NllLibCollectException;
use NllLib\Utils\Url;

class ApiRequest
{

	protected $cache;

	protected $client;

	protected $settings;

	/*
	** The handler_stack is only for testing the library. Otherwise the client
	**  will request the Nopow-Link API.
	*/
	public function __construct($__handlerStack = Null) {
		$this->settings			= ApiSettings::getInstance();
		$this->cache			= ApiCache::getInstance();
		$this->__handlerStack	= $__handlerStack;

		if (!$this->__handlerStack)
		{
			$this->client	= new Client([
				'base_uri'	=> $this->settings->getUrl(),
				'timeout'	=> $this->settings->getTimeout()
				]);
		}
		else
			$this->client	= new Client(['handler' => $this->__handlerStack]);
	}

	public function get_cache()
	{
		return $this->cache;
	}

	public function certify($key)
	{
		try
		{
			/*
			** Le client GuzzleHTTP est immutable. Le timeout de sécurité à
			** besoin d'être désactivé lors de la certification. Car le 
			** processus peut être particulièrement long.
			*/
			if (!$this->__handlerStack)
				$client = new Client(['base_uri' => $this->settings->getUrl()]);
			else
				$client = new Client(['handler' => $this->__handlerStack]);
			$client->request(
				'GET',
				ApiIdentifier::certify($key)
				);
			$this->cache->keySave($key);
			return True;
		}
		catch (TransferException $e) {throw new NllLibCertifyException($e);}
		return False;
	}

	public function collect($slug)
	{
		try
		{
			$key	=  $this->cache->keyRetrieve();
			if (!$key)
				return [];
			$data = $this->cache->linkRetrieve($slug);
			if ($data === Null)
			{
				$response = $this->client->request(
					'GET',
					ApiIdentifier::collect($key, $slug)
					);
				$data = json_decode($response->getBody(), true);
				$this->cache->linkSave($slug, $data);
			}
			return $data;
		}
		catch (TransferException $e) {throw new NllLibCollectException($e);}
		return False;
	}
}
