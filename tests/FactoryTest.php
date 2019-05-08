<?php

namespace MCordingley\BreadcrumbTests;

use MCordingley\Breadcrumbs\Factory;
use MCordingley\Breadcrumbs\Formatter;
use MCordingley\Breadcrumbs\Loader;
use MCordingley\Breadcrumbs\Trail;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class FactoryTest extends TestCase
{
    public function testMake()
    {
        /** @var Formatter|MockObject $formatter */
        $formatter = static::getMockForAbstractClass(Formatter::class);

        /** @var Loader|MockObject $loader */
        $loader = static::getMockForAbstractClass(Loader::class);

        $loader->expects(static::once())
            ->method('load')
            ->with('test', [])
            ->willReturn([]);

        $factory = new Factory($loader, $formatter);

        static::assertInstanceOf(Trail::class, $factory->make('test'));
    }
}
