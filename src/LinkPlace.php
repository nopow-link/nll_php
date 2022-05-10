<?php

namespace NllLib;

class LinkPlace
{

	private $links;

	public function __construct($links)
	{
		$this->links = $links;
		if (count($this->links) > 1)
			uasort($this->links, [__CLASS__,'sortLinks']);

		var_dump($this->links);
	}

	public static function sortLinks($link1, $link2)
	{
		if ($link1['occurence'] == $link2['occurence'])
			return 0;
		return ($link1['occurence'] < $link2['occurence']) ? 1 : -1;
	}

	public function get_links()
	{
		return $this->links;
	}

	public function place($html)
	{
		$result = $html;

		foreach ($this->links as $link)
		{
			$positions	= [];
			$lastPos 	= 0;
			$linkLen	= strlen($link['source']);
			while (($lastPos = strpos($html, $link['source'], $lastPos)) !== false)
			{
			    $positions[] = $lastPos;
			    $lastPos = $lastPos + strlen($linkLen);
			}

			$closest = PHP_INT_MAX;
			foreach ($positions as $key => $position)
			{
				$abs = abs($position - $link['occurence']);
				if ($abs < $closest)
				{
					$closest 	= $abs;
					$pos_id		= $key;
				}
				if ($closest < $linkLen + 1)
				 	break;
			}

			$result = substr_replace($result, $link['substitute'], $positions[$pos_id], $linkLen);
		}

		return $result;
	}
}
