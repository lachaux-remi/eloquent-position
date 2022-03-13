<?php

namespace EloquentPosition\Queries;

use EloquentPosition\Traits\Position;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LastPositionQuery extends AbstractPositionQuery
{
    /**
     * LastPositionQuery constructor.
     */
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
        if ( empty( $this->getOriginalPosition() ) ) {
            $this->getModel()->setPosition( $lastPosition + 1 );
        } else {
            $group = $this->getPositionGroup();
            if ( $group !== null && $this->getModel()->getOriginal( $group ) != $this->getModel()->{$group} ) {
                $this->getModel()->newPositionQuery()
                    ->where( $group, $this->getModel()->getOriginal( $group ) )
                    ->where( $this->positionColumn, ">", $this->getOriginalPosition() )
                    ->decrement( $this->positionColumn );
                $this->getModel()->setPosition( $lastPosition + 1 );
            } else {
                $query
                    ->where( $this->positionColumn, ">", $this->getOriginalPosition() )
                    ->decrement( $this->positionColumn );
                $this->getModel()->setPosition( $lastPosition );
            }
        }
    }
}