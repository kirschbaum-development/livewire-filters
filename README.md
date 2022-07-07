[//]: # (![Mail Intercept banner]&#40;screenshots/banner.jpg&#41;)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kirschbaum-development/livewire-filters)](https://packagist.org/packages/kirschbaum-development/livewire-filters)
[![Total Downloads](https://img.shields.io/packagist/dt/kirschbaum-development/livewire-filters)](https://packagist.org/packages/kirschbaum-development/livewire-filters)
[![Actions Status](https://github.com/kirschbaum-development/livewire-filters/workflows/run-tests/badge.svg)](https://github.com/kirschbaum-development/livewire-filters/actions)

Livewire Filters is a series of Livewire components that provide you with the tools to do live filtering of your data from your own Livewire components.

## Requirements

This package requires Laravel 9.0+ and Livewire 2.10+.

## Installation

To get started, require the package via Composer:

```bash
composer require kirschbaum-development/livewire-filters
```

### Publishing views

The included filters are made with [Tailwind CSS](https://tailwindcss.com) and the [Tailwind CSS Forms plugin](https://github.com/tailwindlabs/tailwindcss-forms). We recommend publishing the views and changing the markup to match whatever styling or CSS framework your project uses.

```bash
php artisan vendor:publish --tag=livewire-filters-views
```

## Usage

### Define your filters

You can use filters in your Livewire component by including the `HasFilters` trait provided by the package.

With the trait included, define a `filters` method that returns an array of `Filter` objects you want to use in your component. The included `Filter` class has a series of fluent methods for building up the specifics of each of your filters.

```php
use HasFilters;

public function filters(): array
{
    return [
        Filter::make('title'),
        Filter::make('type')->options(['text', 'link', 'audio', 'video'])->default(['audio']),
        Filter::make('status')->options(['published', 'draft'])->default('published'),
    ];
}
```

### Use your filters

With your component setup, you can include filters in the view file of your Livewire component. In order to setup the filter, simply use one of the filter components and pass the specific filter by its key. The component will take care of setting itself up.

```blade
<livewire:livewire-filters-checkbox :filter="$filters['type']" />
```

There is more information below about the included filters in the package.

### Determining filtered status/count

The `HasFilters` trait includes two computed properties you can use to determine if there are active filters and how many of your filters are currently active. You can access these directly in your Livewire component by using `$this->isFiltered` or `$this->activeFilterCount`. You can also pass one or both of these properties to your Livewire component through the `render` method if you so choose.

These computed properties are handy if you want to change the color of a button, show/hide a specific section of your UI, show a badge of active filters, or simply show a visual indicator that there are active filters being applied.

### Getting filtered values

Because the `$filters` array contains `Filter` objects, you will need to either access the `value` property, use the `value()` method, or use the included `getFilterValue($key)` helper method.

```php
// Helper included in the HasFilters trait
$this->getFilteredValue('type');

// Using the accessor
$this->filters['type']->value();

// Using the property directly
$this->filters['type']->value;
```

### Example parent component

```php
use App\Models\Post;
use Kirschbaum\LivewireFilters\Filter;
use Kirschbaum\LivewireFilters\HasFilters;
use Livewire\Component;

class PostsList extends Component
{
    use HasFilters;

    public function filters(): array
    {
        return [
            Filter::make('type')->options(['text', 'link', 'audio', 'video'])->default(['text', 'link']),
        ];
    }

    public function getPostsProperty()
    {
        return Post::query()
            ->when($this->getFilterValue('type'), fn ($query, $values) => $query->whereIn('type', $values))
            ->paginate();
    }

    public function render()
    {
        return view('livewire.posts-list', [
            'filterCount' => $this->filterCount,
            'isFiltered' => $this->isFiltered,
            'posts' => $this->posts,
        ]);
    }
}
```

## Included filters

The package includes 4 basic filters that can be used in your Livewire components.

### Checkbox filter

The checkbox filter allows you to select any number of options. Every time a change is made, the filter will emit an event with an array of the currently checked values.

```blade
<livewire:livewire-filters-checkbox :filter="$filters['type']" />
```

| Setting | Type     | Example           |
|---------|----------|-------------------|
| key     | `string` | `'type'`          |
| options | `array`  | `['a', 'b', 'c']` |
| default | `array`  | `['a', 'b']`      |
| value   | `array`  | `['b', 'c']`      |

### Radio button filter

The radio button filter allows you to select a single option from the list of options. Every time a change is made, the filter will emit an event with the currently checked value.

```blade
<livewire:livewire-filters-radio :filter="$filters['type']" />
```

| Setting | Type     | Example           |
|---------|----------|-------------------|
| key     | `string` | `'type'`          |
| options | `array`  | `['a', 'b', 'c']` |
| default | `string` | `'a'`             |
| value   | `string` | `'b'`             |

### Select menu filter

Similar to the radio button filter, the select menu filter allows you to select a single option from the list of options from a select menu. Every time a change is made, the filter will emit an event with the currently selected value.

```blade
<livewire:livewire-filters-select :filter="$filters['type']" />
```

| Setting | Type     | Example           |
|---------|----------|-------------------|
| key     | `string` | `'type'`          |
| options | `array`  | `['a', 'b', 'c']` |
| default | `string` | `'a'`             |
| value   | `string` | `'b'`             |

### Multiselect menu filter

The multiselect menu filter allows you to select multiple options from a list of options. This implementation uses the built in html `multiple` boolean on a select input. Every time a change is made, the filter will emit an event with the currently selected value.

```blade
<livewire:livewire-filters-multiselect :filter="$filters['type']" />
```

| Setting | Type     | Example           |
|---------|----------|-------------------|
| key     | `string` | `'type'`          |
| options | `array`  | `['a', 'b', 'c']` |
| default | `array`  | `['a']`           |
| value   | `array`  | `['b']`           |

### Text box filter

The text box filter allows you to type freeform text that you can use for filtering. Every time a change is made, the filter will emit an event with the value of the text field.

```blade
<livewire:livewire-filters-text :filter="$filters['type']" />
```

| Setting | Type     | Example  |
|---------|----------|----------|
| key     | `string` | `'name'` |
| default | `string` | `'John'` |
| value   | `string` | `'Jane'` |

## The `Filter` class

The `Filter` class provides a fluent interface for defining filters in your Livewire component as well as retrieving information about the filter.

### `make($key)`

The first method you must call is the `make` method and pass it a unique key. After this method has been called, you can call any of the other methods in whatever order you want.

### `options($values)`

If you're using a filter that requires options, you can pass an array of those values into the `options` method. Calling the `options` method without any arguments will return the defined options for the filter.

### `value($values)`

If you would like to set the value of a filter, you can pass the value or an array of values into the `value` method. Calling the `value` method without any arguments will return the current value of the filter.

### `default($values)`

When defining a filter, you should use the `default` method to set the initial value of the filter. This will store the initial value on the object as well to help with determining the status of active filters as well as resetting the filter to its original state. Calling the `default` method without any arguments will return the initial value that you specified when you defined the filter.

### `meta(array $values)`

If you would like to set additional information on the filter to be used in the view file, you can pass an array of values into the `meta` method. Calling the `meta` method without any arguments will return the current array of meta information.

## Events

### `livewire-filters-reset`

### `livewire-filters-updated`

When a filter is updated, it will emit this event with 2 arguments: `key` and `payload`. The key should be used in identifying which filter should be updated. The `payload` is the new value of the filter.

This event is automatically handled by the `HasFilters` trait. If you would like to customize how the updates are handled, you can listen for this event and use your own method or override the `handleUpdateEvent` method.

## Making your own filters

In addition to the included filters, you can also make additional filters to suit your needs.

```php
use Kirschbaum\LivewireFilters\FilterComponent;

class DateFilter extends FilterComponent
{
    public function render()
    {
        return view('livewire.filters.date-filter');
    }
}
```

```blade
<div
    x-data
    x-init="window.flatpickr($refs.flatpickr)"
>
    <input
        type="text"
        name="{{ $key }}"
        id="{{ $key }}"
        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-8 sm:text-sm border-gray-300 rounded-md"
        placeholder="Select a date..."
        readonly="readonly"
        x-ref="flatpickr"
        wire:model="value"
    >

    @if ($value !== $initialValue)
        <div class="absolute inset-y-0 right-2 flex items-center">
            <button type="button" class="text-gray-400 hover:text-gray-500" wire:click="resetValue">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                <span class="sr-only">Reset</span>
            </button>
        </div>
    @endif
</div>
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email david@kirschbaumdevelopment.com or nathan@kirschbaumdevelopment.com instead of using the issue tracker.

## Credits

- [David VanScott](https://github.com/davidvanscott)

## Sponsorship

Development of this package is sponsored by Kirschbaum, a developer driven company focused on problem solving, team building, and community. Learn more [about us](https://kirschbaumdevelopment.com) or [join us](https://careers.kirschbaumdevelopment.com)!

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
