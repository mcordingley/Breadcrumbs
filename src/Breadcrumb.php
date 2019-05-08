<?php

namespace MCordingley\Breadcrumbs;

use Illuminate\Support\Facades\Facade;

/**
 * @method static Trail make(string $path, array $properties = [])
 * @see Factory
 */
final class Breadcrumb extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Factory::class;
    }
}
