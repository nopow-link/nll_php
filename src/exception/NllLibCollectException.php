<?php

namespace NllLib\Exception;

use NllLib\Exception\NllLibReqException;

class NllLibCollectException extends NllLibReqException
{
	protected $ERRORS = [
		'500'	=> "An error occure with the Nopow-Link API. We are sorry for "
			. "the incoveniant.",
		'404'	=> "It's seems, your API key is not valid. Please change your "
			. "key into the your settings.",
		'0'		=> "An error occure.",
		];
}
