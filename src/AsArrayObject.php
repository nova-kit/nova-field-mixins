<?php

namespace NovaKit\Fields\Mixins;

use Illuminate\Support\Str;
use Laravel\Nova\Fields\Field;

class AsArrayObject
{
    /**
     * Bootstrap the mixin from callable.
     *
     * @param  \Laravel\Nova\Fields\Field  $field
     * @return void
     */
    public function __invoke(Field $field)
    {
        $field->attribute = (string) Str::of($field->attribute)->replace('.', '->');

        $field->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
            data_set($model, (string) Str::of($attribute)->replace('->', '.'), $request->input($requestAttribute ?? $attribute));
        });
    }
}
