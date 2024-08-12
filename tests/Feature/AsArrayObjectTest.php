<?php

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use NovaKit\Fields\Mixins\AsArrayObject;

it('can bootstrap the mixins', function () {
    $field = Text::make('Name', 'profile.name')->apply(new AsArrayObject);

    $this->assertSame('profile.name', $field->attribute);
});

it('can fill using the mixins', function () {
    $field = Text::make('Name', 'profile.name')->apply(new AsArrayObject);

    $request = NovaRequest::fake('/nova-api/users/1', 'PUT', [
        'editing' => true,
        'editMode' => 'update',
        'profile_name' => 'Taylor Otwell',
    ]);

    $model = new class extends Model
    {
        protected $casts = [
            'profile' => \Illuminate\Database\Eloquent\Casts\AsArrayObject::class,
        ];
    };

    $field->fillInto($request, $model, 'profile.name');

    $this->assertSame('Taylor Otwell', $model['profile']['name']);
});
