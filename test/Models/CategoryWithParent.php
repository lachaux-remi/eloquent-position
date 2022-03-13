<?php

namespace EloquentPosition\Test\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class CategoryWithParent
 *
 * @property int $parent_id
 */
class CategoryWithParent extends Category
{
    /**
     * Builds a filter from columns for position calculation.
     */
    public $positionGroup = "parent_id";

    public function parent(): BelongsTo
    {
        return $this->belongsTo( self::class );
    }

    public function children(): HasMany
    {
        return $this->hasMany( self::class, "parent_id" );
    }
}