<?php

namespace LachauxRemi\EloquentPosition\Tests\Models;

/**
 * Class CategoryNoPosition
 *
 * @property-read int $id
 * @property ?int $parent_id
 * @property ?int $dummy
 * @property ?int $position
 *
 * @package LachauxRemi\EloquentPosition\Tests\Models
 */
class CategoryNoPosition extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id', 'title', 'dummy', 'position'];
}
