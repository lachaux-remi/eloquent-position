<?php

namespace LachauxRemi\EloquentPosition\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use LachauxRemi\EloquentPosition\Observers\PositionObserver;

/**
 * Trait Position
 *
 * @property string       positionColumn        to enable overriding for the position column
 * @property string|null  positionGroup         builds a filter from columns for position calculation. Supports single
 *                                              column or multiple columns
 * @method static void observe($className)
 * @method Builder newQuery()
 *
 * @package LachauxRemi\EloquentPosition\Traits
 */
trait Position
{
    use BasePosition, PositionScope;

    /**
     * Hook into the Eloquent model events to create or
     * update position as required.
     *
     * @return void
     */
    public static function bootPosition(): void
    {
        static::observe(PositionObserver::class);
    }

    /**
     * Builds the position query. Uses `newQuery` method.
     *
     * @uses Model::newQuery()
     * @return Builder
     */
    public function newPositionQuery(): Builder
    {
        return $this->newQuery();
    }
}
