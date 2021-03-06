<?php

namespace Kirschbaum\LivewireFilters;

class Filter
{
    public function __construct(
        public string $key,
        public ?array $options = [],
        public mixed $value = '',
        public mixed $initialValue = '',
        public array $meta = []
    ) {
    }

    public static function make($key): self
    {
        return new static(key: $key);
    }

    public function isFiltered(): bool
    {
        return $this->value !== $this->initialValue;
    }

    public function __call($name, $arguments)
    {
        if ($name === 'default') {
            if (count($arguments) > 0) {
                $this->value = $arguments[0];
                $this->initialValue = $arguments[0];

                return $this;
            }

            return $this->initialValue;
        }

        if (property_exists($this, $name)) {
            if (count($arguments) > 0) {
                $this->{$name} = $arguments[0];

                return $this;
            }

            return $this->{$name};
        }
    }
}
