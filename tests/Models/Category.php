<?php

namespace LachauxRemi\EloquentPosition\Tests\Models;

use LachauxRemi\EloquentPosition\Traits\Position;

/**
 * Class Category
 *
 * @property-read int $id
 * @property $parent_id
 * @property $dummy
 * @property $position
 *
 * @package LachauxRemi\EloquentPosition\Tests\Models
 */
class Category extends Model
{
    use Position;

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
