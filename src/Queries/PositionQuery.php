<?php

namespace LachauxRemi\EloquentPosition\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use LachauxRemi\EloquentPosition\Traits\Position;

class PositionQuery extends AbstractPositionQuery
{
    /**
     * PositionQuery constructor.
     *
     * @param Model|Position $model
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
        if ($this->getPosition() >= $lastPosition) {
            $this->getModel()->setPosition($lastPosition + 1);
        } else {
            $query
                ->where($this->positionColumn, '>=', $this->getPosition())
                ->increment($this->positionColumn);
            $this->getModel()->setPosition($this->getPosition());
        }
    }
}
