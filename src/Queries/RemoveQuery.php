<?php

namespace EloquentPosition\Queries;

use EloquentPosition\Traits\Position;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RemoveQuery extends AbstractPositionQuery
{
    public function __construct(Model|Position $model)
    {
        parent::__construct( $model );
        $this->run();
    }

    /**
     * Runs the given query
     */
    public function runQuery(Builder $query): void
    {
        $query->where( $this->positionColumn, ">", $this->getPosition() )
            ->decrement( $this->positionColumn );
    }
}