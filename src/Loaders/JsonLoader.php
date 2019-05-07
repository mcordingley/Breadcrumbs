<?php

namespace MCordingley\Breadcrumbs\Loaders;

final class JsonLoader extends Base
{
    private $data;

    public function __construct(string $file)
    {
        $this->data = json_decode(file_get_contents($file), true);
    }

    final protected function loadCrumb(string $path): array
    {
        return $this->data[$path];
    }
}
