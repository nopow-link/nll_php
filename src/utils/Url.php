<?php

namespace NllLib\Utils;

class Url
{
	private $url;

	private $protocole;

	private $host;

	private $slug;

	private $params;

	private $anchor;

	private $status_code;

	public function __construct($url)
	{
		preg_match_all(
			"@^((http[s]?):\/\/)?([a-zA-Z0-9-.]*)?([\/]?[^?#\n]*)"
			. "?([?]?[^?#\n]*)?([#]?[^?#\n]*)$@",
			$url,
			$matches
			);

		$this->url			= $url;
		$this->protocole	= $matches[1][0];
		$this->host			= $matches[2][0];
		$this->slug			= $matches[3][0];
		$this->params		= $matches[4][0];
		$this->anchor		= $matches[5][0];
	}

	public function getAnchor()
	{
		return $this->anchor;
	}

	public function getFullProtocol()
	{
		return $this->getProtocol() . "://";
	}

	public function getHost()
	{
		return $this->host;
	}

	public function getIdentifier()
	{
		return $this->getSlug() . $this->getParams() . $this->getAnchor();
	}

	public function getParams()
	{
		return $this->params;
	}

	public function getProtocol()
	{
		return $this->protocole;
	}

	public function getSlug()
	{
		return $this->slug;
	}

	public function getUrl()
	{
		return $this->sanitalize()
			. $this->getSlug()
			. $this->getParams()
			. $this->getAnchor();
	}

	public function setAnchor($anchor)
	{
		$this->anchor		= $anchor;
		return $this;
	}

	public function setHost($host)
	{
		$this->host			= $host;
		return $this;
	}

	public function setParams($params)
	{
		$this->params		= $params;
		return $this;
	}

	public function setProtocole($protocole)
	{
		$this->protocole	= $protocole;
		return $this;
	}

	public function setSlug($slug)
	{
		$this->slug			= $slug;
		return $this;
	}

	public function sanitalize()
	{
		return $this->getFullProtocol() . $this->getHost() . '/';
	}
}
