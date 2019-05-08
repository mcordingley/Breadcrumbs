<?php

namespace MCordingley\Breadcrumbs\Loaders;

use MCordingley\Breadcrumbs\Crumb;
use MCordingley\Breadcrumbs\Loader;

abstract class Base implements Loader
{
    use ResolvesProperties;

    final public function load(string $path, array $properties = []): array
    {
        $trail = [];

        do {
            $crumb = $this->loadCrumb($path);

            $trail[] = new Crumb(
                $this->resolveProperties($path, $properties),
                $this->resolveProperties($crumb['title'], $properties)
            );
        } while ($path = $crumb['parent'] ?? null);

        return array_reverse($trail);
    }

    /**
     * @param string $path
     * @return array With key "title" and optionally "parent".
     */
    abstract protected function loadCrumb(string $path): array;
}
