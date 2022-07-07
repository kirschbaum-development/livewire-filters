<?php

namespace Kirschbaum\LivewireFilters\Filters;

use Kirschbaum\LivewireFilters\FilterComponent;

class MultiselectFilter extends FilterComponent
{
    public function render()
    {
        return view('livewire-filters::multiselect-filter');
    }
}
