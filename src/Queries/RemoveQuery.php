<?php

namespace LachauxRemi\EloquentPosition\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use LachauxRemi\EloquentPosition\Traits\Position;

class RemoveQuery extends AbstractPositionQuery
{
    /**
     * RemoveQuery constructor.
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
        $query
            ->where($this->positionColumn, '>', $this->getPosition())
            ->decrement($this->positionColumn);
    }
}
