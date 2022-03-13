<?php

namespace EloquentPosition\Observers;

use EloquentPosition\Queries\LastPositionQuery;
use EloquentPosition\Queries\MoveQuery;
use EloquentPosition\Queries\PositionQuery;
use EloquentPosition\Queries\RemoveQuery;
use EloquentPosition\Traits\Position;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PositionObserver
 */
class PositionObserver
{
    public function saving(Model|Position $model): void
    {
        $position = $model->getPosition();
        $originalPosition = $model->getOriginal( $model->getPositionColumn() );

        if ( empty( $position ) ) {
            new LastPositionQuery( $model );
        } else if ( is_null( $originalPosition ) ) {
            new PositionQuery( $model );
        } else {
            new MoveQuery( $model );
        }
    }

    public function deleting(Model|Position $model): void
    {
        new RemoveQuery( $model );
    }
}