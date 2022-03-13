<?php

namespace EloquentPosition\Test\Models;

/**
 * Class CategoryNoPosition
 *
 * @property-read int $id
 * @property int $parent_id
 * @property int $dummy
 * @property int $position
 */
class CategoryNoPosition extends Model
{
    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     */
    protected $table = "categories";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [ "parent_id", "title", "dummy", "position" ];
}