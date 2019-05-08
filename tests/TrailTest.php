<?php

namespace MCordingley\BreadcrumbTests;

use MCordingley\Breadcrumbs\Crumb;
use MCordingley\Breadcrumbs\Formatter;
use MCordingley\Breadcrumbs\Trail;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class TrailTest extends TestCase
{
    public function testRegularUse()
    {
        /** @var Formatter|MockObject $formatter */
        $formatter = static::getMockForAbstractClass(Formatter::class);

        $trail = new Trail([
            new Crumb('a', 'b'),
            new Crumb('c', 'd'),
        ], $formatter);

        $formatter->expects(static::once())
            ->method('format')
            ->with($trail)
            ->willReturn('formatted');

        static::assertEquals('formatted', $trail->render());
        static::assertEquals('c', $trail->tail()->url());
        static::assertEquals(2, count($trail));

        foreach ($trail as $index => $crumb) {
            static::assertIsInt($index);
            static::assertInstanceOf(Crumb::class, $crumb);
        }
    }

    public function testEmptyList()
    {
        /** @var Formatter|MockObject $formatter */
        $formatter = static::getMockForAbstractClass(Formatter::class);

        $trail = new Trail([], $formatter);

        static::assertNull($trail->tail());
        static::assertEquals(0, count($trail));
    }
}
