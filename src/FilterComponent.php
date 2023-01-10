<?php

namespace Kirschbaum\LivewireFilters;

use Illuminate\Support\Arr;
use Livewire\Component;

abstract class FilterComponent extends Component
{
    public mixed $initialValue;

    public string $key = '';

    public array $meta = [];

    public array $options = [];

    public mixed $value = null;

    public function mount(Filter $filter): void
    {
        $this->key = $filter->key();
        $this->meta = $filter->meta();
        $this->options = $filter->options();

        if (config('livewire-filters.query_string_enabled')) {
            $this->value = request()?->query($filter->key()) ?? $filter->value();
        } else {
            $this->value = $filter->value();
        }

        $this->initialValue = $filter->value();
    }

    protected function queryString(): array
    {
        if (!config('livewire-filters.query_string_enabled')) {
            return [];
        }

        return [
            'value' => [
                'as' => $this->key,
            ],
        ];
    }

    public function resetValue(): void
    {
        $this->value = $this->initialValue;

        $this->emitFilterEvent();
    }

    public function getOptionId($value): string
    {
        return $this->key . '-' . strtolower(str_replace(' ', '_', $value));
    }

    public function getOptionName($value): string
    {
        return $this->key . '-' . strtolower(str_replace(' ', '_', $value));
    }

    public function getOptionValue($id, $value): mixed
    {
        if (Arr::isAssoc($this->options)) {
            return $id;
        }

        return $value;
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
            'livewire-filters-reset' => 'resetValue',
        ]);
    }
}
