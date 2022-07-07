<?php

namespace Kirschbaum\LivewireFilters;

use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Kirschbaum\LivewireFilters\Filters\TextFilter;
use Kirschbaum\LivewireFilters\Filters\RadioFilter;
use Kirschbaum\LivewireFilters\Filters\SelectFilter;
use Kirschbaum\LivewireFilters\Filters\CheckboxFilter;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Kirschbaum\LivewireFilters\Filters\MultiselectFilter;

class LivewireFiltersServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('livewire-filters')
            ->hasViews();
    }

    public function bootingPackage(): void
    {
        Livewire::component('livewire-filters-checkbox', CheckboxFilter::class);
        Livewire::component('livewire-filters-radio', RadioFilter::class);
        Livewire::component('livewire-filters-select', SelectFilter::class);
        Livewire::component('livewire-filters-multiselect', MultiselectFilter::class);
        Livewire::component('livewire-filters-text', TextFilter::class);
    }
}
