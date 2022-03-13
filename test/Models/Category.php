<?php

namespace EloquentPosition\Test\Models;

use EloquentPosition\Traits\Position;

/**
 * Class Category
 *
 * @property-read int $id
 * @property int $parent_id
 * @property int $dummy
 * @property int $position
 */
class Category extends Model
{
    use Position;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "categories";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ "parent_id", "title", "dummy", "position" ];
}