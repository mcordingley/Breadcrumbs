<?php

namespace MCordingley\Breadcrumbs\Formatters;

use Illuminate\Support\Facades\View as IlluminateView;
use MCordingley\Breadcrumbs\Formatter;
use MCordingley\Breadcrumbs\Trail;

final class View implements Formatter
{
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function format(Trail $trail): string
    {
        $view = IlluminateView::make($this->path, ['trail' => $trail]);

        return $view->render();
    }
}
