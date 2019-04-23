<?php

declare(strict_types=1);

namespace blubolt\HeadTags\Tests;

use blubolt\HeadTags\BuilderInterface;
use blubolt\HeadTags\OpenGraphBuilder;
use Generator;

/**
 * Class OpenGraphBuilderTest
 */
class OpenGraphBuilderTest extends TestCase
{
	/** @var BuilderInterface */
	protected $builder;

	public function setUp(): void
	{
		$this->builder = new OpenGraphBuilder();
	}

	public function tearDown(): void
	{
		unset($this->builder);
	}

	/**
	 * @dataProvider dataBuildSet
	 * @param mixed[] $set
	 * @param string  $result
	 */
	public function testBuild(array $set, string $result): void
	{
		foreach ($set as $args) {
			call_user_func_array([$this->builder, 'add'], $args);
		}

		$this->assertHtmlStringEqualsHtmlFile($result, '<head>' . $this->builder->build() . '</head>');
	}

	public function dataBuildSet(): Generator
	{
		yield [[], __DIR__ . '/assets/EmptyBuilder0.html'];

		yield [
			[
				['og:type', 'website'],
				['title', 'stub title'],
				['description', 'stub description'],
				['image', 'stub image 1', ['alt' => 'stub image 1 alt']],
				['image', 'stub image 2'],
			],
			__DIR__ . '/assets/OpenGraphBuilder1.html',
		];
	}
}
