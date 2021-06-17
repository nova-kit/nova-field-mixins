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
        Field::macro('apply', function ($mixin, ...$parameters) {
            if (\is_string($mixin) && class_exists($mixin)) {
                $mixin = new $mixin();
            }

            if (! \is_callable($mixin)) {
                throw new InvalidArgumentException('Unable to mixin non-callable $mixin');
            }

            $mixin($this, ...$parameters);

            return $this;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
