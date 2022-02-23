<?php

namespace Kirschbaum\LivewireFilters\Filters;

use Kirschbaum\LivewireFilters\FilterComponent;

class SelectFilter extends FilterComponent
{
    public function render()
    {
        return view('livewire-filters::select-filter');
    }
}
