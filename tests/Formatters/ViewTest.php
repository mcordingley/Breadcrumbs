<?php

namespace MCordingley\BreadcrumbTests\Formatters;

use Illuminate\Support\Facades\View as IlluminateViewFacade;
use Illuminate\View\View as BladeView;
use MCordingley\Breadcrumbs\Crumb;
use MCordingley\Breadcrumbs\Formatter;
use MCordingley\Breadcrumbs\Formatters\View as BreadcrumbView;
use MCordingley\Breadcrumbs\Trail;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class ViewTest extends TestCase
{
    public function testFormat()
    {
        /** @var Formatter|MockObject $formatter */
        $formatter = static::getMockForAbstractClass(Formatter::class);

        $trail = new Trail([
            new Crumb('a', 'b'),
            new Crumb('c', 'd'),
        ], $formatter);

        /** @var BladeView|MockObject $view */
        $view = static::createMock(BladeView::class);

        $view->expects(static::once())
            ->method('render')
            ->willReturn('foo');

        IlluminateViewFacade::shouldReceive('make')
            ->once()
            ->with('breadcrumbs::bootstrap', ['trail' => $trail])
            ->andReturn($view);

        $formatter = new BreadcrumbView('breadcrumbs::bootstrap');

        static::assertEquals('foo', $formatter->format($trail));
    }
}
