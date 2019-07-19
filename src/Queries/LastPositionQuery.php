<?php

namespace LachauxRemi\EloquentPosition\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use LachauxRemi\EloquentPosition\Traits\Position;

class LastPositionQuery extends AbstractPositionQuery
{
    /**
     * LastPositionQuery constructor.
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
        if (is_null($this->getOriginalPosition()) || empty($this->getOriginalPosition())) {
            $this->getModel()->setPosition($lastPosition + 1);
        } else {
            $group = $this->getPositionGroup();
            if ($group !== null && $this->getModel()->getOriginal($group) !== $this->getModel()->{$group}) {
                $this->getModel()->newPositionQuery()
                    ->where($group, $this->getModel()->getOriginal($group))
                    ->where($this->positionColumn, '>', $this->getOriginalPosition())
                    ->decrement($this->positionColumn);
                $this->getModel()->setPosition($lastPosition + 1);
            } else {
                $query
                    ->where($this->positionColumn, '>', $this->getOriginalPosition())
                    ->decrement($this->positionColumn);
                $this->getModel()->setPosition($lastPosition);
            }
        }
    }
}
