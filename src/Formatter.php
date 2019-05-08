<?php

namespace MCordingley\Breadcrumbs;

interface Formatter
{
    public function format(Trail $trail): string;
}
