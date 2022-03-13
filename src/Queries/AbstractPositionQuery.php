<?php

namespace EloquentPosition\Queries;

use EloquentPosition\Traits\Position;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractPositionQuery
{
    protected Position|Model $model;

    protected string $positionColumn;

    protected ?int $position;

    protected mixed $originalPosition;

    protected Builder $query;

    public function __construct(Model|Position $model)
    {
        $this->model = $model;

        $this->positionColumn = $model->getPositionColumn();
        $this->position = $model->getPosition();
        $this->originalPosition = $model->getOriginal( $this->positionColumn );
        $this->query = $this->buildQuery();
    }

    /**
     * Builds the basic query and appends a where conditions for group is set
     */
    protected function buildQuery(): Builder
    {
        $query = $this->model->newPositionQuery();

        $group = $this->getPositionGroup();
        if ( $group ) {
            $this->applyGroupWhere( $query, $group );
        }

        return $query;
    }

    protected function getPositionGroup(): ?string
    {
        return $this->getModel()->getPositionGroup();
    }

    public function getModel(): Model|Position
    {
        return $this->model;
    }

    /**
     * Applies where condition for given column into the query. Takes value
     * from the model.
     */
    protected function applyGroupWhere(Builder $query, string $column): Builder
    {
        $value = $this->model->{$column};

        if ( is_null( $value ) ) {
            return $query->whereNull( $column );
        }

        return $query->where( $column, $value );
    }

    /**
     * Runs the query for position change
     */
    public function run(): void
    {
        $this->runQuery( $this->getQuery() );
    }

    /**
     * Runs the given query
     */
    abstract public function runQuery(Builder $query): void;

    public function getQuery(): Builder
    {
        return $this->query;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function getOriginalPosition(): ?int
    {
        return $this->originalPosition;
    }
}