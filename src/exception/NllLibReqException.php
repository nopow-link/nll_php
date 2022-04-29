<?php

namespace NllLib\Exception;

use \Exception;
use \Throwable;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
#use GuzzleHttp\Exception\BadResponseException;
#use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ClientException;
#use GuzzleHttp\Exception\TooManyRedirectsException;

class NllLibReqException extends Exception
{

	protected $ERRORS;

	public function __construct(TransferException $exception, $code = 0,
		Throwable $previous = null
		)
	{
		$request 	= $exception->getRequest();

		if ($exception instanceof RequestException)
		{
			$response = $exception->getResponse();
			$code = $response->getStatusCode();
		}
		$message = (array_key_exists($code, $this->ERRORS))
			? $this->ERRORS[$code]
			: "An error occure with our request API.";

		parent::__construct($message, $code, $previous);
	}

	public function __toString()
	{
		return $this->message;
	}
}
