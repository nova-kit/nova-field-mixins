<?php

namespace NovaKit\Fields\Mixins;

use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;
use Laravel\Nova\Fields\Field;

class MixinServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Field::macro('apply', function ($mixin, ...$parameters) {
            /** @var class-string|callable $mixin */
            if (\is_string($mixin) && class_exists($mixin)) {
                $mixin = app($mixin);
            }

            if (! \is_callable($mixin)) {
                throw new InvalidArgumentException('Unable to mixin non-callable $mixin');
            }

            $mixin($this, ...$parameters);

            return $this;
        });

        Field::macro('fromArrayObject', function () {
            $mixin = app(AsArrayObject::class);

            $mixin($this);

            return $this;
        });
    }
}
