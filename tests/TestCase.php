<?php

namespace NovaKit\Fields\Mixins\Tests;

use NovaKit\Fields\Mixins\MixinServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            MixinServiceProvider::class,
        ];
    }

}
