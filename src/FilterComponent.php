<?php

namespace Kirschbaum\LivewireFilters;

use Livewire\Component;

abstract class FilterComponent extends Component
{
    public mixed $initialValue;

    public string $key = '';

    public array $options = [];

    public mixed $value;

    public function mount(Filter $filter): void
    {
        $this->key = $filter->key();
        $this->options = $filter->options();
        $this->value = $filter->value();

        $this->initialValue = $this->value;
    }

    public function resetValue(): void
    {
        $this->value = $this->initialValue;

        $this->emitFilterEvent();
    }

    public function updatedValue(): void
    {
        $this->emitFilterEvent();
    }

    protected function emitFilterEvent(): void
    {
        $this->emit('livewire-filters-updated', $this->key, $this->value);
    }

    protected function getListeners(): array
    {
        return array_merge($this->listeners, [
            'livewire-filters-reset' => 'resetValue'
        ]);
    }
}
