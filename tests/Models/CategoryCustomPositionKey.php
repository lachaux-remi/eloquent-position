<?php

namespace LachauxRemi\EloquentPosition\Tests\Models;

/**
 * Class CategoryCustomPositionKey
 *
 * @property int $dummy
 * @property ?int $position
 *
 * @package LachauxRemi\EloquentPosition\Tests\Models
 */
class CategoryCustomPositionKey extends Category
{
    /**
     * @var string
     */
    public $positionColumn = 'dummy';
}
