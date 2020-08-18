<?php 

namespace Armincms\Duration\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\{ID, Text, Select, Number};
use Armincms\Nova\Resource; 
use Armincms\Fields\Targomaan;
 
abstract class Duration extends Resource
{ 
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Armincms\\Duration\\Duration'; 

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'label'; 

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'label', 'interval',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    { 
    	return [
    		ID::make(),

    		Select::make(__('Interval'), 'interval')
    			->options(static::intervals())
    			->required()
    			->rules('required')
    			->default('day'),

    		Number::make(__('Length'), 'length') 
    			->required()
    			->default(1)
    			->min(1)
    			->rules(['required', 'min:1']),

    		new Targomaan([
    			Text::make(__('Label'), 'label')
    				->required()
    				->rules('required'),
    		]),
    	];
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
			'hour'   => __('Hour'), 
			'day'    => __('Day'), 
			'week'   => __('Week'), 
			'month'  => __('Month'), 
			'year'   => __('Year')
		];
	}
}