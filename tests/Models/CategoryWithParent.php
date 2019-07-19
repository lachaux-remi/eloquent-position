<?php

namespace LachauxRemi\EloquentPosition\Tests\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class CategoryWithParent
 *
 * @property $parent_id
 *
 * @package LachauxRemi\EloquentPosition\Tests\Models
 */
class CategoryWithParent extends Category
{
    /**
     * Builds a filter from columns for position calculation.
     *
     * @var string
     */
    public $positionGroup = 'parent_id';

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this
            ->belongsTo(self::class);
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this
            ->hasMany(self::class, 'parent_id');
    }
}
