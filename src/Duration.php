<?php

namespace Armincms\Duration;

use Illuminate\Database\Eloquent\{Model, SoftDeletes};  
use Armincms\Targomaan\Concerns\InteractsWithTargomaan; 

class Duration extends Model 
{   
    use SoftDeletes, InteractsWithTargomaan;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'interval' => 'string',
        'length'   => 'integer',
    ]; 

    public function translator()
    {
        return 'sequential';
    }
}
