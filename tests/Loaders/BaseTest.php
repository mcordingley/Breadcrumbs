<?php

namespace MCordingley\BreadcrumbTests\Loaders;

use Illuminate\Support\Arr;
use MCordingley\Breadcrumbs\Crumb;
use MCordingley\Breadcrumbs\Loader;
use MCordingley\Breadcrumbs\Loaders\Base;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use stdClass;

final class BaseTest extends TestCase
{
    public function testPropertyInjection()
    {
        $data = new stdClass;
        $data->id = 4;
        $data->name = "Test";

        /** @var Loader|MockObject $loader */
        $loader = static::getMockForAbstractClass(Base::class);

        $loader->expects(static::exactly(3))
            ->method('loadCrumb')
            ->withConsecutive(
                ['/test/sub/{foo.id}/edit'],
                ['/test/sub'],
                ['/test']
            )
            ->willReturnOnConsecutiveCalls(
                [
                    'title' => 'Edit {foo.name}',
                    'parent' => '/test/sub',
                ],
                [
                    'title' => 'Sub',
                    'parent' => '/test',
                ],
                [
                    'title' => 'Test',
                ]
            );

        $trail = $loader->load('/test/sub/{foo.id}/edit', [
            'foo' => $data,
        ]);

        /** @var Crumb $tail */
        $tail = Arr::last($trail);

        static::assertEquals('Edit Test', $tail->title());
        static::assertEquals('/test/sub/4/edit', $tail->url());
    }
}
