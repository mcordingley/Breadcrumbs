<?php

namespace MCordingley\Breadcrumbs;

final class Factory
{
    private $formatter;
    private $loader;

    public function __construct(Loader $loader, Formatter $formatter)
    {
        $this->loader = $loader;
        $this->formatter = $formatter;
    }

    public function make(string $path, array $properties = []): Trail
    {
        return new Trail(
            $this->loader->load($path, $properties),
            $this->formatter
        );
    }
}
