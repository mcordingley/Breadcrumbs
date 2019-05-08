<?php

namespace MCordingley\Breadcrumbs\Formatters;

use MCordingley\Breadcrumbs\Formatter;
use MCordingley\Breadcrumbs\Trail;

final class View implements Formatter
{
    private $view;

    public function __construct(string $view)
    {
        $this->view = $view;
    }

    public function format(Trail $trail): string
    {
        /** @var \Illuminate\Contracts\View\View $view */
        $view = view($this->view, ['trail' => $this]);

        return $view->render();
    }
}
