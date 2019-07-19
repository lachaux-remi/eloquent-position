<?php

namespace LachauxRemi\EloquentPosition\Queries;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use LachauxRemi\EloquentPosition\Traits\Position;

abstract class AbstractPositionQuery
{
    /**
     * @var Model|Position
     */
    protected $model;

    /**
     * @var string
     */
    protected $positionColumn;

    /**
     * @var int|null
     */
    protected $position;

    /**
     * @var int|null
     */
    protected $originalPosition;

    /**
     * @var Builder
     */
    protected $query;

    /**
     * AbstractPositionQuery constructor.
     *
     * @param Model|Position $model
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;

        $this->positionColumn = $model->getPositionColumn();
        $this->position = $model->getPosition();
        $this->originalPosition = $model->getOriginal($this->positionColumn);
        $this->query = $this->buildQuery();
    }

    /**
     * Runs the query for position change
     * @return void
     */
    public function run(): void
    {
        $this->runQuery($this->getQuery());
    }

    /**
     * Runs the given query
     *
     * @param Builder $query
     * @return void
     */
    abstract public function runQuery(Builder $query): void;

    /**
     * Builds the basic query and appends a where conditions for group is set
     *
     * @return Builder
     */
    protected function buildQuery(): Builder
    {
        $query = $this->model->newPositionQuery();

        $group = $this->getPositionGroup();
        if ($group) {
            $this->applyGroupWhere($query, $group);
        }

        return $query;
    }

    /**
     * @return string|null
     */
    protected function getPositionGroup(): ?string
    {
        return $this->getModel()->getPositionGroup();
    }

    /**
     * Applies where condition for given column into the query. Takes value
     * from the model.
     *
     * @param Builder $query
     * @param string $column
     * @return Builder
     */
    protected function applyGroupWhere(Builder $query, string $column): Builder
    {
        $value = $this->model->{$column};

        if (is_null($value)) {
            return $query->whereNull($column);
        }

        return $query->where($column, $value);
    }

    /**
     * @return Model|Position
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return int|null
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @return int|null
     */
    public function getOriginalPosition(): ?int
    {
        return $this->originalPosition;
    }

    /**
     * @return Builder
     */
    public function getQuery(): Builder
    {
        return $this->query;
    }
}
