<?php

namespace Armincms\Duration\Nova;

use Armincms\Contract\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Duration extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Armincms\Duration\Models\Duration::class;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'label',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make(),

            Text::make(__('Duration Label'), fn () => $this->title()),

            Select::make(__('Duration Interval'), 'interval')
                ->options(static::intervals())
                ->required()
                ->rules('required')
                ->default('day')
                ->sortable()
                ->filterable()
                ->displayUsingLabels(),

            Number::make(__('Duration Length'), 'length')
                ->required()
                ->default(1)
                ->min(1)
                ->rules('required', 'min:1')
                ->filterable()
                ->sortable(),

            ...collect(app('application.locales'))->flatMap(function ($locale) {
                return [
                    Text::make(__("Duration Label - [{$locale['name']}]"), "label->{$locale['locale']}")
                        ->required()
                        ->onlyOnForms()
                        ->help($locale['name']),
                ];
            }),
        ];
    }

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return (string) data_get($this, 'label.'.app()->getLocale());
    }

    /**
     * Get the available intervals.
     *
     * @return array
     */
    public static function intervals()
    {
        return [
            'minute' => __('Minute'),
            'hour' => __('Hour'),
            'day' => __('Day'),
            'week' => __('Week'),
            'month' => __('Month'),
            'year' => __('Year'),
        ];
    }

    /**
     * Return the location to redirect the user after creation.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Nova\Resource  $resource
     * @return \Laravel\Nova\URL|string
     */
    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        return '/resources/'.static::uriKey();
    }

    /**
     * Return the location to redirect the user after update.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Nova\Resource  $resource
     * @return \Laravel\Nova\URL|string
     */
    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        return '/resources/'.static::uriKey();
    }
}
