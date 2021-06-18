<?php

namespace NovaKit\Fields\Mixins\Tests\Feature;

use Laravel\Nova\Fields\Text;
use NovaKit\Fields\Mixins\Recipes\AsArrayObject;
use NovaKit\Fields\Mixins\Tests\TestCase;

class CallableMixinTest extends TestCase
{
    /** @test */
    public function it_can_apply_with_parameters()
    {
        $field = Text::make('Name')->apply(function ($field, $suggestions) {
            $field->suggestions($suggestions);
        }, ['Taylor Otwell', 'David Hemphill', 'Mior Muhammad Zaki']);

        $this->assertSame('name', $field->attribute);
        $this->assertSame(['Taylor Otwell', 'David Hemphill', 'Mior Muhammad Zaki'], $field->suggestions);
    }

    /** @test */
    public function it_can_handle_callable_string_class_name()
    {
        $field = Text::make('Name', 'profile.name')->apply(AsArrayObject::class);

        $this->assertSame('profile->name', $field->attribute);
    }

    /** @test */
    public function it_cannot_handle_non_callable_object()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Unable to mixin non-callable $mixin');

        $field = Text::make('Name')->apply(new class() {
            //
        });
    }
}
