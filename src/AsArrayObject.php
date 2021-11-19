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
        $field->resolveUsing(function ($value, $model, $attribute) {
            return data_get($model, $attribute);
        })->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
            data_set($model, $attribute, $request->input((string) Str::of($requestAttribute ?? $attribute)->replace('.', '_')));
        });
    }
}
