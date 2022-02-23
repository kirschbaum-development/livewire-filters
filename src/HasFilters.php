<?php

namespace Kirschbaum\LivewireFilters;

trait HasFilters
{
    public array $filters = [];

    public array $initialFilters = [];

    public function filters(): array
    {
        return [];
    }

    public function getIsFilteredProperty(): bool
    {
        return $this->filters !== $this->initialFilters;
    }

    public function hydrateHasFilters(): void
    {
        $this->filters = $this->filters();

        $this->initialFilters = $this->filters;
    }
}
