<?php

namespace MCordingley\Breadcrumbs;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

final class Facade extends IlluminateFacade
{
    protected static function getFacadeAccessor()
    {
        return 'breadcrumbs';
    }
}
