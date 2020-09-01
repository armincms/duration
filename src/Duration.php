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
        'label'     => 'json',
        'interval'  => 'string',
        'length'    => 'integer',
    ];  

    public function days()
    {
        return $this->length * $this->getIntervalAsDays();
    }

    public function getIntervalAsDays()
    {
        return $this->getIntervalRelevantDays($this->interval);
    }

    protected function getIntervalRelevantDays(string $interval)
    {
        $now  = now();  

        return $now->diffInDays($now->copy()->modify("1 {$interval}"), false); 
    } 
}
