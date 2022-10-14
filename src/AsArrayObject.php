<?php

namespace NovaKit\Fields\Mixins;

use Illuminate\Support\Str;
use Laravel\Nova\Fields\Field;

class AsArrayObject
{
    /**
     * Bootstrap the mixin from callable.
     *
     * @return void
     */
    public function __invoke(Field $field)
    {
        $field->attribute = (string) Str::of($field->attribute)->replace('->', '.');

        $field->fillUsing(function ($request, $model, $attribute, $requestAttribute) use ($field) {
            $value = $request->input((string) Str::of($requestAttribute ?? $attribute)->replace('.', '_'));

            data_set($model, $attribute, (! $field->isValidNullValue($value) ? $value : null));
        });
    }
}
