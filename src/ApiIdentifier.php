<?php

namespace NllLib;

class ApiIdentifier
{
	public static function certify($api_key)
	{
		return sprintf("api/public/plugin/%s/certify", $api_key);
	}

	public static function collect($api_key, $slug)
	{
		return sprintf(
			"api/public/plugin/%s/collect?slug=%s",
			$api_key,
			$slug
			);
	}
}
