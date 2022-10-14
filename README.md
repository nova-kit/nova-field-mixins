
Laravel Nova Field Mixins
==============

[![tests](https://github.com/nova-kit/nova-field-mixins/workflows/tests/badge.svg?branch=master)](https://github.com/nova-kit/nova-field-mixins/actions?query=workflow%3Atests+branch%3Amaster)
[![Latest Stable Version](https://poser.pugx.org/nova-kit/nova-field-mixins/v/stable)](https://packagist.org/packages/nova-kit/nova-field-mixins)
[![Total Downloads](https://poser.pugx.org/nova-kit/nova-field-mixins/downloads)](https://packagist.org/packages/nova-kit/nova-field-mixins)
[![Latest Unstable Version](https://poser.pugx.org/nova-kit/nova-field-mixins/v/unstable)](https://packagist.org/packages/nova-kit/nova-field-mixins)
[![License](https://poser.pugx.org/nova-kit/nova-field-mixins/license)](https://packagist.org/packages/nova-kit/nova-field-mixins)
[![Coverage Status](https://coveralls.io/repos/github/nova-kit/nova-field-mixins/badge.svg?branch=master)](https://coveralls.io/github/nova-kit/nova-field-mixins?branch=master)

## Installation 

To install through composer, run the following command from terminal:

```bash 
composer require "nova-kit/nova-field-mixins"
```

## Usages

Laravel Nova Field Mixins is useful to apply set common set of configuration to Field without repeating it. E.g:

```php
use Laravel\Nova\Fields\DateTime;

DateTime::make('Created At')->sortable()->displayUsing(fn ($d) => $d?->diffForHumans()),
DateTime::make('Updated At')->sortable()->displayUsing(fn ($d) => $d?->diffForHumans()),
```

By adding following class `App\Nova\Fields\Mixins\StandardDateTime`:

```php
<?php 

namespace App\Nova\Fields\Mixins;

use Laravel\Nova\Fields\Field;

class StandardDateTime
{
    public function __invoke(Field $field)
    {
        $field->sortable()->displayUsing(fn ($d) => $d?->diffForHumans());
    }
}
```

You can now write above example as:

```php
use App\Nova\Fields\Mixins\StandardDateTime;
use Laravel\Nova\Fields\DateTime;

DateTime::make('Created At')->apply(StandardDateTime::class),
DateTime::make('Updated At')->apply(StandardDateTime::class),
```

### Available Mixin

#### Handle `AsArrayobject` Cast

This package provide a default implement casting for `AsArrayObject`.

```php
use Laravel\Nova\Fields\Text;
use NovaKit\Fields\Mixins\AsArrayObject;

Text::make('Name', 'profile.name')->apply(new AsArrayObject()),
```

You can also simplify this by using `fromArrayObject` macro.

```php
use Laravel\Nova\Fields\Text;

Text::make('Name', 'profile.name')->fromArrayObject(),
```

