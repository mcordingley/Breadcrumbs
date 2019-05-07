<?php

namespace MCordingley\Breadcrumbs;

use ArrayIterator;
use Countable;
use Illuminate\Support\Arr;
use IteratorAggregate;

final class Trail implements Countable,
    IteratorAggregate
{
    private $crumbs = [];

    /**
     * @param Breadcrumb[] $crumbs
     */
    public function __construct(array $crumbs)
    {
        foreach ($crumbs as $crumb) {
            $this->addCrumb($crumb);
        }
    }

    private function addCrumb(Breadcrumb $crumb): void
    {
        $this->crumbs[] = $crumb;
    }

    public function tail(): ?Breadcrumb
    {
        return Arr::last($this->crumbs);
    }

    public function count()
    {
        return count($this->crumbs);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->crumbs);
    }
}
