<?php

namespace EloquentPosition\Queries;

use EloquentPosition\Traits\Position;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MoveQuery extends AbstractPositionQuery
{
    protected bool $increment = false;

    /**
     * Comparison condition for old position value.
     * In default is for decrement.
     */
    protected string $oldComparisonCondition = ">";

    /**
     * Comparison condition for new position value.
     * In default is for decrement.
     */
    protected string $newComparisonCondition = "<=";

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

        $group = $this->getPositionGroup();
        if ( $group !== null && $this->getModel()->getOriginal( $group ) != $this->getModel()->{$group} ) {
            $this->getModel()->newPositionQuery()
                ->where( $group, $this->getModel()->getOriginal( $group ) )
                ->where( $this->positionColumn, ">", $this->getOriginalPosition() )
                ->decrement( $this->positionColumn );

            if ( $this->getPosition() > $lastPosition ) {
                $this->getModel()->setPosition( $lastPosition + 1 );
            } else {
                $this->getModel()->setPosition( $this->getPosition() );
                $query
                    ->where( $this->positionColumn, ">=", $this->getPosition() )
                    ->increment( $this->positionColumn );
            }
        } else {
            // Indicate if si the increment/decrement
            $this->increment = $this->getPosition() < $this->getOriginalPosition();
            $this->buildComparisonCondition();


            if ( $this->getPosition() >= $lastPosition ) {
                $this->getModel()->setPosition( $lastPosition );
            } else {
                $this->getModel()->setPosition( $this->getPosition() );
            }

            $query = $query
                ->where( $this->positionColumn, $this->oldComparisonCondition, $this->getOriginalPosition() )
                ->where( $this->positionColumn, $this->newComparisonCondition, $this->getPosition() );

            if ( $this->increment ) {
                $query->increment( $this->positionColumn );
            } else {
                $query->decrement( $this->positionColumn );
            }
        }
    }

    /**
     * Builds the correct comparison condition
     */
    protected function buildComparisonCondition(): void
    {
        if ( $this->increment ) {
            $this->oldComparisonCondition = "<";
            $this->newComparisonCondition = ">=";
        }
    }
}