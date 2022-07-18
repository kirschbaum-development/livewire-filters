<?php

namespace Kirschbaum\LivewireFilters;

use ArrayAccess;
use Livewire\Wireable;

class FilterCollection implements ArrayAccess, Wireable
{
    public function __construct(
        public array $items = []
    ) {
    }

    public static function make(array $items): self
    {
        return new static($items);
    }

    public function toLivewire(): array
    {
        return $this->items;
    }

    public static function fromLivewire($value): self
    {
        $filters = collect($value)
            ->flatMap(fn ($values, $key) => [$key => $values instanceof Filter ? $values : new Filter(...$values)])
            ->all();

        return new static($filters);
    }

    public function offsetExists(mixed $key): bool
    {
        return isset($this->items[$key]);
    }

    public function offsetGet(mixed $key): mixed
    {
        return $this->items[$key];
    }

    public function offsetSet(mixed $key, mixed $value): void
    {
        if (is_null($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    public function offsetUnset(mixed $key): void
    {
        unset($this->items[$key]);
    }
}
