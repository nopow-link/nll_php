<?php

namespace NllLib\Tests;

use PHPUnit\Framework\TestCase;
use duzun\hQuery;

use NllLib\LinkPlace;
use NllLib\Utils\Path;

class LinkPlaceTest extends TestCase
{

	public static function JSON_EXAMPLE_1()
	{
		return json_encode([
			[
				"pk"			=> 1,
				"source"		=> "<p>Some representative placeholder content for the first slide of the carousel.</p>",
				"occurence"		=> 4607,
				"substitute"	=> "<p>Some <a href='#'>representative</a> placeholder content for the first slide of the carousel.</p>"
				]
			]);
	}

	public static function JSON_EXAMPLE_2()
	{
		return json_encode([
			[
				"pk"			=> 1,
				"source"		=> '<p class="lead">And an even wittier subheading.</p>',
				"occurence"		=> 3120,
				"substitute"	=> '<p class="lead">And an even <a href="#">representative</a> subheading.</p>'
			],
			[
				"pk"			=> 1,
				"source"		=> '<p class="lead">And an even wittier subheading.</p>',
				"occurence"		=> 5441,
				"substitute"	=> '<p class="lead">And an even <a href="#">representative</a> subheading.</p>'
				]
			]);
	}

	public function testPlaceSingleLink()
	{
		$path 	= new Path(__FILE__);
		$links	= LinkPlaceTest::JSON_EXAMPLE_1();
		$placer	= new LinkPlace(json_decode($links, True));
		$html	= hQuery::fromFile($path->absolut('./html/Example1.html'));

		$result 	= $placer->place(strval($html));
		$expected 	= file_get_contents($path->absolut('./html_result/Example1.html'));
		$this->assertSame($result, $expected);
	}

	public function testPlaceMultipleLink()
	{
		$path 	= new Path(__FILE__);
		$links	= LinkPlaceTest::JSON_EXAMPLE_2();
		$placer	= new LinkPlace(json_decode($links, True));
		$html	= hQuery::fromFile($path->absolut('./html/Example2.html'));

		$result		= $placer->place(strval($html));
		$expected 	= file_get_contents($path->absolut('./html_result/Example2.html'));
		$this->assertSame($result, $expected);
	}
}
