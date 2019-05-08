<?php

namespace MCordingley\Breadcrumbs;

use ArrayIterator;
use Countable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Arr;
use IteratorAggregate;

final class Trail implements Countable,
    IteratorAggregate,
    Renderable
{
    private $crumbs = [];
    private $formatter;

    public function __construct(array $crumbs, Formatter $formatter)
    {
        foreach ($crumbs as $crumb) {
            $this->addCrumb($crumb);
        }

        $this->formatter = $formatter;
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

    public function render(): string
    {
        return $this->formatter->format($this);
    }
}
