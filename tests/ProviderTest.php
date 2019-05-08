<?php

namespace MCordingley\BreadcrumbTests;

use Exception;
use MCordingley\Breadcrumbs\Breadcrumb;
use MCordingley\Breadcrumbs\Crumb;
use MCordingley\Breadcrumbs\Formatter;
use MCordingley\Breadcrumbs\Loader;
use MCordingley\Breadcrumbs\Provider;
use Orchestra\Testbench\TestCase;

final class ProviderTest extends TestCase
{
    protected function getPackageAliases($app)
    {
        return [
            'Breadcrumb' => Breadcrumb::class,
        ];
    }

    protected function getPackageProviders($app)
    {
        return [
            Provider::class,
        ];
    }

    public function testProviderDefaults()
    {
        config([
            'breadcrumbs' => [
                'formatter' => 'view',
                'formatters' => [
                    'view' => [
                        'path' => 'breadcrumbs::bootstrap',
                    ],
                ],
                'loader' => 'json',
                'loaders' => [
                    'json' => [
                        'path' => __DIR__ . '/Loaders/crumbs.json',
                    ],
                ],
            ],
        ]);

        $trail = Breadcrumb::make('/test/sub/create');
        $output = $trail->__toString();

        static::assertStringContainsString('Create', $output);
    }

    public function testCustomFactories()
    {
        config([
            'breadcrumbs' => [
                'formatter' => 'custom',
                'formatters' => [
                    'custom' => [
                        'via' => 'custom-formatter',
                    ],
                ],
                'loader' => 'custom',
                'loaders' => [
                    'custom' => [
                        'via' => 'custom-loader',
                    ],
                ],
            ],
        ]);

        $formatterMock = static::getMockForAbstractClass(Formatter::class);

        $formatterMock->expects(static::once())
            ->method('format')
            ->willReturn('foo');

        $formatterFactory = new class($formatterMock) {
            private $formatterMock;

            public function __construct($formatterMock)
            {
                $this->formatterMock = $formatterMock;
            }

            public function __invoke()
            {
                return $this->formatterMock;
            }
        };

        $this->app->instance('custom-formatter', $formatterFactory);

        $loaderMock = static::getMockForAbstractClass(Loader::class);

        $loaderMock->expects(static::once())
            ->method('load')
            ->with('/test/sub/create')
            ->willReturn([
                new Crumb('/test/sub/create', 'Foo'),
            ]);

        $loaderFactory = new class($loaderMock) {
            private $loaderMock;

            public function __construct($loaderMock)
            {
                $this->loaderMock = $loaderMock;
            }

            public function __invoke()
            {
                return $this->loaderMock;
            }
        };

        $this->app->instance('custom-loader', $loaderFactory);

        $trail = Breadcrumb::make('/test/sub/create');

        static::assertEquals('foo', $trail->__toString());
    }

    public function testBadFormatter()
    {
        config([
            'breadcrumbs' => [
                'formatter' => 'fubar',
                'formatters' => [
                    'view' => [
                        'path' => 'breadcrumbs::bootstrap',
                    ],
                ],
                'loader' => 'json',
                'loaders' => [
                    'json' => [
                        'path' => __DIR__ . '/Loaders/crumbs.json',
                    ],
                ],
            ],
        ]);

        static::expectException(Exception::class);

        Breadcrumb::make('/test/sub/create');
    }

    public function testBadLoader()
    {
        config([
            'breadcrumbs' => [
                'formatter' => 'view',
                'formatters' => [
                    'view' => [
                        'path' => 'breadcrumbs::bootstrap',
                    ],
                ],
                'loader' => 'fubar',
                'loaders' => [
                    'json' => [
                        'path' => __DIR__ . '/Loaders/crumbs.json',
                    ],
                ],
            ],
        ]);

        static::expectException(Exception::class);

        Breadcrumb::make('/test/sub/create');
    }
}
