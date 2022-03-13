<?php

namespace EloquentPosition\Traits;

use EloquentPosition\Observers\PositionObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait Position
 *
 * @property string positionColumn to enable overriding for the position column
 * @property string|null positionGroup builds a filter from columns for position calculation. Supports single column or multiple columns
 * @method static void observe( string $className )
 * @method Builder newQuery()
 */
trait Position
{
    use BasePosition, PositionScope;

    /**
     * Hook into the Eloquent model events to create or
     * update position as required.
     */
    public static function bootPosition(): void
    {
        static::observe( PositionObserver::class );
    }

    /**
     * Builds the position query. Uses `newQuery` method.
     *
     * @uses Model::newQuery()
     */
    public function newPositionQuery(): Builder
    {
        return $this->newQuery();
    }
}