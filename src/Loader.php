<?php

namespace MCordingley\Breadcrumbs;

interface Loader
{
    /**
     * @param string $path
     * @param array $properties
     * @return Crumb[]
     */
    public function load(string $path, array $properties = []): array;
}
