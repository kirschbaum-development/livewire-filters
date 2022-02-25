<?php

namespace Kirschbaum\LivewireFilters;

trait HasFilters
{
    public array $activeFilters = [];

    public array $filters = [];

    public function emitResetEvent(): void
    {
        $this->emit('livewire-filters-reset');
    }

    public function filters(): array
    {
        return [];
    }

    public function getFilterValue($key): mixed
    {
        return $this->filters[$key]->value();
    }

    public function getActiveFilterCountProperty(): int
    {
        return count($this->activeFilters);
    }

    public function getIsFilteredProperty(): bool
    {
        return count($this->activeFilters) > 0;
    }

    public function handleUpdateEvent($key, $payload): void
    {
        $this->setFilterValue($key, $payload);

        $this->calculateActiveFilters($key);
    }

    public function initializeHasFilters(): void
    {
        foreach ($this->filters() as $filter) {
            $this->filters[$filter->key()] = $filter;
        }
    }

    public function setFilterValue($key, $value): void
    {
        $this->filters[$key]->value($value);
    }

    protected function calculateActiveFilters($key): void
    {
        if ($this->filters[$key]->isFiltered()) {
            $this->activeFilters[$key] = 'active';
        } else {
            unset($this->activeFilters[$key]);
        }
    }

    protected function getListeners(): array
    {
        return array_merge($this->listeners, [
            'livewire-filters-updated' => 'handleUpdateEvent',
        ]);
    }
}
