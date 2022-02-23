<?php

namespace Kirschbaum\LivewireFilters;

use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
        Livewire::component('livewire-filters-text', TextFilter::class);
    }
}
