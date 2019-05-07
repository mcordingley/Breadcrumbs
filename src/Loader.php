<?php

namespace MCordingley\Breadcrumbs;

interface Loader
{
    public function loadTrail(string $path, array $properties = []): Trail;
}
