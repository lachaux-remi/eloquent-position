<?php

namespace LachauxRemi\EloquentPosition\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use LachauxRemi\EloquentPosition\Traits\Position;

class MoveQuery extends AbstractPositionQuery
{
    /**
     * @var bool
     */
    protected $increment = false;

    /**
     * Comparision condition for old position value.
     * In default is for decrement.
     *
     * @var string
     */
    protected $oldComparisionCondition = '>';

    /**
     * Comparision condition for new position value.
     * In default is for decrement.
     *
     * @var string
     */
    protected $newComparisionCondition = '<=';

    /**
     * MoveQuery constructor.
     *
     * @param Model|Position $model
     * @return void
     */
    public function __construct($model)
    {
        parent::__construct($model);
        $this->run();
    }

    /**
     * Runs the given query
     *
     * @param Builder $query
     * @return void
     */
    public function runQuery(Builder $query): void
    {
        $lastPosition = $query->max($this->positionColumn) ?: 0;

        $group = $this->getPositionGroup();
        if ($group !== null && $this->getModel()->getOriginal($group) != $this->getModel()->{$group}) {
            $this->getModel()->newPositionQuery()
                ->where($group, $this->getModel()->getOriginal($group))
                ->where($this->positionColumn, '>', $this->getOriginalPosition())
                ->decrement($this->positionColumn);

            if ($this->getPosition() > $lastPosition) {
                $this->getModel()->setPosition($lastPosition + 1);
            } else {
                $this->getModel()->setPosition($this->getPosition());
                $query
                    ->where($this->positionColumn, '>=', $this->getPosition())
                    ->increment($this->positionColumn);
            }
        } else {
            // Indicate if si the increment/decrement
            $this->increment = $this->getPosition() < $this->getOriginalPosition();
            $this->buildComparisionCondition();


            if ($this->getPosition() >= $lastPosition) {
                $this->getModel()->setPosition($lastPosition);
            } else {
                $this->getModel()->setPosition($this->getPosition());
            }

            $query = $query
                ->where($this->positionColumn, $this->oldComparisionCondition, $this->getOriginalPosition())
                ->where($this->positionColumn, $this->newComparisionCondition, $this->getPosition());

            if ($this->increment) {
                $query->increment($this->positionColumn);
            } else {
                $query->decrement($this->positionColumn);
            }
        }
    }

    /**
     * Builds the correct comparision condition
     *
     * @return void
     */
    protected function buildComparisionCondition(): void
    {
        if ($this->increment) {
            $this->oldComparisionCondition = '<';
            $this->newComparisionCondition = '>=';
        }
    }
}
