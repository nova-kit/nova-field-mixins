<?php

namespace NovaKit\Fields\Mixins\Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use NovaKit\Fields\Mixins\AsArrayObject;
use NovaKit\Fields\Mixins\Tests\TestCase;

class AsArrayObjectTest extends TestCase
{
    /** @test */
    public function it_can_bootstrap_the_mixins()
    {
        $field = Text::make('Name', 'profile.name')->apply(new AsArrayObject());

        $this->assertSame('profile.name', $field->attribute);
    }

    /** @test */
    public function it_can_fill_using_the_mixins()
    {
        $field = Text::make('Name', 'profile.name')->apply(new AsArrayObject());

        $request = NovaRequest::create('/nova-api/users/1', 'PUT', [
            'editing' => true,
            'editMode' => 'update',
            'profile.name' => 'Taylor Otwell',
        ]);

        $model = new class() extends Model {
            protected $casts = [
                'profile' => \Illuminate\Database\Eloquent\Casts\AsArrayObject::class,
            ];
        };

        $field->fillInto($request, $model, 'profile.name');

        ray($model);

        $this->assertSame('Taylor Otwell', $model['profile']['name']);
    }
}
