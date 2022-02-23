<?php

namespace Kirschbaum\LivewireFilters;

use Livewire\Component;

abstract class FilterComponent extends Component
{
    public string $eventName = '';

    public mixed $initialValue;

    public array $options = [];

    public mixed $value;

    public function hydrate(): void
    {
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
        $this->emit($this->eventName, $this->value);
    }
}
