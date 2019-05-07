<?php

namespace MCordingley\BreadcrumbTests\Loaders;

use MCordingley\Breadcrumbs\Loaders\JsonLoader;
use PHPUnit\Framework\TestCase;

final class JsonLoaderTest extends TestCase
{
    public function testLoad()
    {
        $loader = new JsonLoader(__DIR__ . '/crumbs.json');

        $trail = $loader->load('/test/sub/create');

        static::assertEquals('Base Test', $trail[0]->title());
        static::assertEquals('Sub', $trail[1]->title());
        static::assertEquals('Create', $trail[2]->title());

        static::assertEquals('/test', $trail[0]->url());
        static::assertEquals('/test/sub', $trail[1]->url());
        static::assertEquals('/test/sub/create', $trail[2]->url());
    }
}
