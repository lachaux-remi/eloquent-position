<?php

namespace LachauxRemi\EloquentPosition\Tests\Models;

/**
 * Class CategoryCustomPositionKey
 *
 * @property $dummy
 * @property $position
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
