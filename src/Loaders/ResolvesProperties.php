<?php

namespace MCordingley\Breadcrumbs\Loaders;

trait ResolvesProperties
{
    final protected function resolveProperties(string $subject, array $properties): string
    {
        return preg_replace_callback('/{(.*?)}/', function (array $matches) use ($properties): string {
            return data_get($properties, $matches[1], '');
        }, $subject);
    }
}
