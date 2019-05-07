<?php

namespace MCordingley\BreadcrumbTests;

use MCordingley\Breadcrumbs\Loaders\JsonLoader;
use PHPUnit\Framework\TestCase;
use stdClass;

final class ExpectedUseTest extends TestCase
{
    public function testSimpleUse()
    {
        $loader = new JsonLoader(__DIR__ . '/crumbs.json');

        $trail = $loader->loadTrail('/test/sub/create');

        $crumbs = [];

        foreach ($trail as $crumb) {
            $crumbs[] = $crumb;
        }

        static::assertEquals($crumbs[2], $trail->tail());

        static::assertEquals('Base Test', $crumbs[0]->title());
        static::assertEquals('Sub', $crumbs[1]->title());
        static::assertEquals('Create', $crumbs[2]->title());

        static::assertEquals('/test', $crumbs[0]->url());
        static::assertEquals('/test/sub', $crumbs[1]->url());
        static::assertEquals('/test/sub/create', $crumbs[2]->url());
    }

    public function testCountable()
    {
        $loader = new JsonLoader(__DIR__ . '/crumbs.json');

        $trail = $loader->loadTrail('/test/sub/create');

        static::assertEquals(3, count($trail));
    }

    public function testPropertyInjection()
    {
        $data = new stdClass;
        $data->id = 4;
        $data->name = "Test";

        $loader = new JsonLoader(__DIR__ . '/crumbs.json');

        $trail = $loader->loadTrail('/test/sub/{foo.id}/edit', [
            'foo' => $data,
        ]);

        $tail = $trail->tail();

        static::assertEquals('Edit Test', $tail->title());
        static::assertEquals('/test/sub/4/edit', $tail->url());
    }
}
