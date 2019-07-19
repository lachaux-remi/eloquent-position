<?php

namespace LachauxRemi\EloquentPosition\Observers;

use Illuminate\Database\Eloquent\Model;
use LachauxRemi\EloquentPosition\Queries\LastPositionQuery;
use LachauxRemi\EloquentPosition\Queries\MoveQuery;
use LachauxRemi\EloquentPosition\Queries\PositionQuery;
use LachauxRemi\EloquentPosition\Queries\RemoveQuery;
use LachauxRemi\EloquentPosition\Traits\Position;

/**
 * Class PositionObserver
 * @package LachauxRemi\EloquentPosition\Observers
 */
class PositionObserver
{
    /**
     * @param Model|Position $model
     * @return void
     */
    public function saving(Model $model): void
    {
        $position = $model->getPosition();
        $originalPosition = $model->getOriginal($model->getPositionColumn());

        if (is_null($position) || empty($position)) {
            new LastPositionQuery($model);
        } elseif (is_null($originalPosition)) {
            new PositionQuery($model);
        } else {
            new MoveQuery($model);
        }
    }

    /**
     * @param Model|Position $model
     * @return void
     */
    public function deleting($model): void
    {
        new RemoveQuery($model);
    }
}
