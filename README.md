[//]: # (![Mail Intercept banner]&#40;screenshots/banner.jpg&#41;)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kirschbaum-development/livewire-filters)](https://packagist.org/packages/kirschbaum-development/livewire-filters)
[![Total Downloads](https://img.shields.io/packagist/dt/kirschbaum-development/livewire-filters)](https://packagist.org/packages/kirschbaum-development/livewire-filters)
[![Actions Status](https://github.com/kirschbaum-development/livewire-filters/workflows/run-tests/badge.svg)](https://github.com/kirschbaum-development/livewire-filters/actions)

Livewire Filters is a Livewire component that provides you with live filters for your own Livewire components.

## Requirements

This package requires Laravel 9.0+ and Livewire 2.10+.

## Installation

To get started, require the package via Composer:

```bash
composer require kirschbaum-development/livewire-filters
```

## Publishing views

The included filters are made with [Tailwind CSS](https://tailwindcss.com) and the [Tailwind CSS Forms plugin](https://github.com/tailwindlabs/tailwindcss-forms). We recommend publishing the views and changing the markup to match whatever styling or CSS framework your project uses.

```bash
php artisan vendor:publish --tag=livewire-filters-views
```

## Usage

### Example parent component

```php
use App\Models\Post;
use Kirschbaum\LivewireFilters\Concerns\HasFilters;
use Livewire\Component;

class PostsList extends Component
{
    use HasFilters;

    protected $listeners = [
        'postTypeUpdated' => 'handlePostTypeUpdate',
    ];

    public function filters(): array
    {
        return [
            'type' => ['text', 'link'],
        ];
    }

    public function handlePostTypeUpdate($value)
    {
        $this->filters['type'] = $value;
    }

    public function getPostsProperty()
    {
        return Post::query()
            ->when($this->filters['type'], fn ($query, $values) => $query->whereIn('type', $values))
            ->paginate();
    }

    public function render()
    {
        return view('livewire.posts-list', [
            'isFiltered' => $this->isFiltered,
            'posts' => $this->posts,
        ]);
    }
}
```

#### Apply `HasFilters` trait to your component

On your Livewire component, you should include the `HasFilters` trait. This will give you some helpers to work with filters in your component.

#### Define your filters

The simplest way to use the filters is from a component that defines all of the available filters. The `HasFilters` trait includes a `filter` method that should return an `array` of any filters you want to use.

```php
public function filters(): array
{
    return [
        'type' => ['text', 'link'],
        'status' => 'published',
        'tags' => '',
        'author' => '',
    ];
}
```

When the component hydrates, the filters will be made available in a `$filters` variable.

#### Handle filter events

Filter components emit an event when there is a change that your component(s) can listen for and react to. Using the filters we defined, we can define event listeners and then handle those events as they happen. The `HasFilters` trait includes an `updateFilter` method that accepts the filter's unique key and the value to update it with. You are also welcome to directly update the `$filters` variable if you want.

```php
protected $listeners = [
    'postTypeUpdated' => 'handlePostTypeUpdate',
];

public function handlePostTypeUpdate($value)
{
    $this->filters['type'] = $value;
}
```

#### Determining filtered status

The `HasFilters` trait includes a computed property that you can use to determine if filters beyond the defaults have been applied. You can access this directly in your Livewire component by using `$this->isFiltered` or by passing it to your Livewire component through the `render` method.

This property is handy if you want to change the color of a button, show/hide a specific section of your UI, or simply show a visual indicator that there are active filters being applied.

## Included filters

The package includes 4 basic filters that can be used in your Livewire components.

### Checkbox filter

The checkbox filter allows you to select any number of options. Every time a change is made, the filter will emit an event with an array of the currently checked values.

```blade
@livewire('livewire-filters-checkbox', [
    'eventName' => 'postTypeUpdated',
    'options' => ['text', 'link', 'audio', 'video'],
    'value' => $filters['type']
])
```

### Radio button filter

The radio button filter allows you to select a single option from the list of options. Every time a change is made, the filter will emit an event with the currently checked value.

```blade
@livewire('livewire-filters-radio', [
    'eventName' => 'postStatusUpdated',
    'options' => ['published', 'draft'],
    'value' => $filters['status']
])
```

### Select menu filter

The select menu filter allows you to select a single option from the list of options from a select menu. Every time a change is made, the filter will emit an event with the currently selected value.

```blade
@livewire('livewire-filters-select', [
    'eventName' => 'postAuthorUpdated',
    'options' => ['John', 'Paul', 'Ringo', 'George'],
    'value' => $filters['author']
])
```

### Text box filter

The text box filter allows you to type freeform text that you can use for filtering. Every time a change is made, the filter will emit an event with the value of the text field.

```blade
@livewire('livewire-filters-text', [
    'eventName' => 'postTagsUpdated',
    'value' => $filters['tags']
])
```

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
        name="{{ $eventName }}"
        id="{{ $eventName }}"
        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-8 sm:text-sm border-gray-300 rounded-md"
        placeholder="Select a date..."
        readonly="readonly"
        x-ref="flatpickr"
        wire:model="value"
    >

    @if ($value)
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