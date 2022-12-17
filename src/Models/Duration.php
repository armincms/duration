<?php

namespace Armincms\Duration\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Duration extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'label' => AsArrayObject::class,
    ];

    /**
     * Calculate the days.
     *
     * @return float
     */
    public function days(): float
    {
        return $this->length * $this->getIntervalAsDays();
    }

    /**
     * Calculate the days for the interval.
     *
     * @return float
     */
    public function getIntervalAsDays(): float
    {
        return floatval($this->getIntervalRelevantDays($this->interval));
    }

    /**
     * Calculate the day for the given interval string.
     *
     * @return float
     */
    protected function getIntervalRelevantDays(string $interval)
    {
        return with(now(), fn ($now) => $now->diffInDays($now->copy()->modify("1 {$interval}"), false));
    }

    /**
     * Get the value that should be displayed to represent the model.
     *
     * @return string
     */
    public function title(): string
    {
        return (string) data_get($this, 'label.'.app()->getLocale()) ?? array_shift((array) $this->name);
    }
}
