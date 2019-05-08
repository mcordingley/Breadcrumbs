<?php

namespace MCordingley\Breadcrumbs;

final class Crumb
{
    private $title;
    private $url;

    public function __construct(string $url, string $title)
    {
        $this->url = $url;
        $this->title = $title;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function title(): string
    {
        return $this->title;
    }
}
