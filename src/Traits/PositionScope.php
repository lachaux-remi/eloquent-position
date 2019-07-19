<?php

namespace LachauxRemi\EloquentPosition\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait PositionScope
 *
 * @method static Builder sorted(string $way = 'ASC')
 * @method static Builder sortedByDESC()
 *
 * @package LachauxRemi\EloquentPositionable\Traits
 */
trait PositionScope
{
    /**
     * Sorts the results
     *
     * @param Builder $builder
     * @param string|null $way
     * @return Builder
     */
    public function scopeSorted(Builder $builder, ?string $way = 'ASC'): Builder
    {
        return $builder->orderBy($this->getPositionColumn(), $way);
    }

    /**
     * Sorts the results in DESC
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeSortedByDESC(Builder $builder): Builder
    {
        return $this->scopeSorted($builder, 'DESC');
    }
}
