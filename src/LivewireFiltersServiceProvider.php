<?php

namespace Kirschbaum\LivewireFilters;

use Kirschbaum\LivewireFilters\Filters\CheckboxFilter;
use Kirschbaum\LivewireFilters\Filters\RadioFilter;
use Kirschbaum\LivewireFilters\Filters\SelectFilter;
use Kirschbaum\LivewireFilters\Filters\TextFilter;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LivewireFiltersServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('livewire-filters')
            ->hasConfigFile()
            ->hasViews();
    }

    public function bootingPackage(): void
    {
        Livewire::component('livewire-filters-checkbox', CheckboxFilter::class);
        Livewire::component('livewire-filters-radio', RadioFilter::class);
        Livewire::component('livewire-filters-select', SelectFilter::class);
        Livewire::component('livewire-filters-text', TextFilter::class);
    }
}
