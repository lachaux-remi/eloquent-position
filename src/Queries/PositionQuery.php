<?php

namespace EloquentPosition\Queries;

use EloquentPosition\Traits\Position;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PositionQuery extends AbstractPositionQuery
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
        $lastPosition = $query->max( $this->positionColumn ) ?: 0;
        if ( $this->getPosition() >= $lastPosition ) {
            $this->getModel()->setPosition( $lastPosition + 1 );
        } else {
            $query->where( $this->positionColumn, ">=", $this->getPosition() )
                ->increment( $this->positionColumn );
            $this->getModel()->setPosition( $this->getPosition() );
        }
    }
}