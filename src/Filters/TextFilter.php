<?php

namespace Kirschbaum\LivewireFilters\Filters;

use Kirschbaum\LivewireFilters\FilterComponent;

class TextFilter extends FilterComponent
{
    public function render()
    {
        return view('livewire-filters::text-filter');
    }
}
