<?php

namespace Kirschbaum\LivewireFilters\Filters;

use Kirschbaum\LivewireFilters\FilterComponent;

class CheckboxFilter extends FilterComponent
{
    public function render()
    {
        return view('livewire-filters::checkbox-filter');
    }
}
