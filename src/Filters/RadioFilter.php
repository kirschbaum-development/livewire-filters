<?php

namespace Kirschbaum\LivewireFilters\Filters;

use Kirschbaum\LivewireFilters\FilterComponent;

class RadioFilter extends FilterComponent
{
    public function render()
    {
        return view('livewire-filters::radio-filter');
    }
}
