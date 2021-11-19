<?php

namespace NovaKit\Fields\Mixins;

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
        $field->resolveUsing(function ($model, $attribute) {
            return data_get($model, $attribute);
        })->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
            data_set($model, $attribute, $request->{$requestAttribute ?? $attribute} ?? null);
        });
    }
}
