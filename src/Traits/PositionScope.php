<?php

namespace EloquentPosition\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait PositionScope
 *
 * @method static Builder sorted( string $way = 'ASC' )
 * @method static Builder sortedByDESC()
 */
trait PositionScope
{
    /**
     * Sorts the results in DESC
     */
    public function scopeSortedByDESC(Builder $builder): Builder
    {
        return $this->scopeSorted( $builder, "DESC" );
    }

    /**
     * Sorts the results
     */
    public function scopeSorted(Builder $builder, ?string $way = "ASC"): Builder
    {
        return $builder->orderBy( $this->getPositionColumn(), $way );
    }
}