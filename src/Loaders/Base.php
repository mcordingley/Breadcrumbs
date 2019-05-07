<?php

namespace MCordingley\Breadcrumbs\Loaders;

use MCordingley\Breadcrumbs\Breadcrumb;
use MCordingley\Breadcrumbs\Loader;
use MCordingley\Breadcrumbs\Trail;

abstract class Base implements Loader
{
    final public function loadTrail(string $path, array $properties = []): Trail
    {
        $trail = [];

        do {
            $crumb = $this->loadCrumb($path);

            $trail[] = new Breadcrumb(
                $this->resolveProperties($path, $properties),
                $this->resolveProperties($crumb['title'], $properties)
            );
        } while ($path = $crumb['parent'] ?? null);

        return new Trail(array_reverse($trail));
    }

    /**
     * @param string $path
     * @return array With keys "title", "url", and optionally "parent".
     */
    abstract protected function loadCrumb(string $path): array;

    private function resolveProperties(string $subject, array $properties): string
    {
        return preg_replace_callback('/{(.*?)}/', function (array $matches) use ($properties): string {
            return data_get($properties, $matches[1], '');
        }, $subject);
    }
}
