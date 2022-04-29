<?php

namespace NllLib\Tests;

use PHPUnit\Framework\TestCase;

use NllLib\ApiRequest;

class ApiRequestTest extends TestCase
{
	public function testCertifyRequest()
	{
		$requests	= new ApiRequest();
		$key		= "example_64763d626330a485fe2602a38e17a91fa376fd01ad";

		$requests->certify($key);
	}
}
