<?php

namespace EloquentPosition\Test;

use EloquentPosition\Test\Models\Category;

class ScopeHelperTest extends TestCase
{
    /** @test */
    public function queryScope(): void
    {
        $model_1 = Category::create();
        Category::create();
        $model_3 = Category::create();

        $models = Category::sorted()->get();
        $this->assertEquals( $model_1->getKey(), $models->first()->getKey() );
        $this->assertEquals( $model_3->getKey(), $models->last()->getKey() );
    }

    /** @test */
    public function queryScopeDESC(): void
    {
        $model_1 = Category::create();
        Category::create();
        $model_3 = Category::create();

        $models = Category::sortedByDESC()->get();
        $this->assertEquals( $model_1->getKey(), $models->last()->getKey() );
        $this->assertEquals( $model_3->getKey(), $models->first()->getKey() );
    }
}