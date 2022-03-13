<?php

namespace EloquentPosition\Test\Models;

/**
 * Class CategoryCustomPositionKey
 *
 * @property int $dummy
 * @property int $position
 */
class CategoryCustomPositionKey extends Category
{
    public string $positionColumn = "dummy";
}