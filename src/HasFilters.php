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

    // TODO: How should we handle attempting to get a filter that doesn't exist?
    public function getFilter($key): mixed
    {
        return $this->filters[$key];
    }

    public function getFilters(): array
    {
        return $this->filters;
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

    public function resetFilter($key): void
    {
        $this->updateFilter($key, $this->initialFilters[$key]);
    }

    public function resetFilters(): void
    {
        $this->updateFilters($this->initialFilters);
    }

    // TODO: How should we handle attempting to update a filter that doesn't exist?
    public function updateFilter($key, $value): void
    {
        $this->filters[$key] = $value;
    }

    public function updateFilters($value): void
    {
        $this->filters = $value;
    }
}
