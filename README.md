[//]: # (![Mail Intercept banner]&#40;screenshots/banner.jpg&#41;)

# Livewire Filters

### A package for handling simple filters with Laravel Livewire.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kirschbaum-development/livewire-filters)](https://packagist.org/packages/kirschbaum-development/livewire-filters)
[![Total Downloads](https://img.shields.io/packagist/dt/kirschbaum-development/livewire-filters)](https://packagist.org/packages/kirschbaum-development/livewire-filters)
[![Actions Status](https://github.com/kirschbaum-development/livewire-filters/workflows/run-tests/badge.svg)](https://github.com/kirschbaum-development/livewire-filters/actions)


## Requirements

This package requires Laravel 9.0 or higher and Livewire 2.10 or higher.

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

### The parent component

#### Defining your filters

The simplest way to use the filters is from a component that defines all of the available filters. Additionally, if the component is used as a parent, you can pass down the default values of your filters into the individual filter components.

```php
public array $filters = [
    'type' => ['text', 'link'],
    'status' => 'published',
    'tags' => '',
    'author' => '',
];
```

#### Handling filter events

Filter components will emit an event when there is a change that your component(s) can listen for and react to. Using the filters we defined, we can define listeners and then handle those events as they happen.

```php
protected $listeners = [
    'postTypeUpdated' => 'handlePostTypeUpdate',
];

public function handlePostTypeUpdate($value)
{
    $this->filters['type'] = $value;
}
```

## Included filters

The package includes 4 basic filters that can be used in your Livewire components.

### Checkbox filter

```blade
@livewire('livewire-filters-checkbox', [
    'eventName' => 'postTypeUpdated',
    'options' => ['text', 'link', 'audio', 'video'],
    'value' => $filters['type']
])
```

### Radio button filter

```blade
@livewire('livewire-filters-radio', [
    'eventName' => 'postStatusUpdated',
    'options' => ['published', 'draft'],
    'value' => $filters['status']
])
```

### Select menu filter

```blade
@livewire('livewire-filters-select', [
    'eventName' => 'postAuthorUpdated',
    'options' => ['John', 'Paul', 'Ringo', 'George'],
    'value' => $filters['author']
])
```

### Textbox filter

```blade
@livewire('livewire-filters-text', [
    'eventName' => 'postTagsUpdated',
    'value' => $filters['tags']
])
```

## Making your own filters

In addition to the included filters, you can also make additional filters to suit your needs.

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