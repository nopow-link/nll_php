<?php

namespace NllLib\Exception;

use NllLib\Exception\NllLibReqException;

class NllLibCertifyException extends NllLibReqException
{
	protected $ERRORS = [
		'404'	=> "It's seems the API is not valid. Please check your API key "
			. "in your Nopow-Link account.",
		];
}