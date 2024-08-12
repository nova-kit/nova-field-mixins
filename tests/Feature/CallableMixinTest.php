<?php

use Laravel\Nova\Fields\Text;
use NovaKit\Fields\Mixins\AsArrayObject;

it('can apply with parameters', function () {
    $field = Text::make('Name')->apply(function ($field, $suggestions) {
        $field->suggestions($suggestions);
    }, ['Taylor Otwell', 'David Hemphill', 'Mior Muhammad Zaki']);

    $this->assertSame('name', $field->attribute);
    $this->assertSame(['Taylor Otwell', 'David Hemphill', 'Mior Muhammad Zaki'], $field->suggestions);
});

it('can handle callable string class name', function () {
    $field = Text::make('Name', 'profile.name')->apply(AsArrayObject::class);

    $this->assertSame('profile.name', $field->attribute);
});

it('cannot handle non callable object', function () {
    $this->expectException('InvalidArgumentException');
    $this->expectExceptionMessage('Unable to mixin non-callable $mixin');

    $field = Text::make('Name')->apply(new class
    {
        //
    });
});
