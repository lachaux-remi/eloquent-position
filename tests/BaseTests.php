<?php

namespace LachauxRemi\EloquentPosition\Tests;

use Exception;
use LachauxRemi\EloquentPosition\Tests\Models\Category;
use LachauxRemi\EloquentPosition\Tests\Models\CategoryCustomPositionKey;

/**
 * Class BaseTests
 * @package LachauxRemi\EloquentPosition\Tests
 */
class BaseTests extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function addAfterLastPosition(): void
    {
        $model_1 = Category::create();
        $this->assertEquals(1, $model_1->getPosition());
        $model_2 = Category::create(['position' => '']);
        $this->assertEquals(2, $model_2->getPosition());
    }

    /**
     * @test
     * @return void
     */
    public function addWithExcessivePosition(): void
    {
        $model_1 = Category::create();
        $model_2 = Category::create(['position' => 5]);

        $model_1 = Category::find($model_1->id);
        $this->assertEquals(1, $model_1->getPosition());
        $this->assertEquals(2, $model_2->getPosition());
    }

    /**
     * @test
     * @return void
     */
    public function addWithDefinedPositionToOne(): void
    {
        $model_1 = Category::create();
        for ($i = 1; $i < 5; $i++) {
            Category::create();
        }

        $model_5 = Category::create(['position' => 1]);
        $this->assertEquals(1, $model_5->getPosition());

        $model_1 = Category::find($model_1->id);
        $this->assertEquals(2, $model_1->getPosition());
    }

    /**
     * @test
     * @return void
     */
    public function updatePosition(): void
    {
        $model_1 = Category::create();
        $model_2 = Category::create();
        $model_1->update(['position' => null]);

        $model_1 = Category::find($model_1->id);
        $this->assertEquals(2, $model_1->getPosition());
        $model_2 = Category::find($model_2->id);
        $this->assertEquals(1, $model_2->getPosition());
    }

    /**
     * @test
     * @return void
     */
    public function updateWithDefinedLowerPosition(): void
    {
        $model_1 = Category::create();
        $model_2 = Category::create();
        $model_3 = Category::create();
        $model_4 = Category::create();
        $model_5 = Category::create();

        $model_5->update(['position' => 2]);

        $model_1 = Category::find($model_1->id);
        $this->assertEquals(1, $model_1->getPosition());
        $model_5 = Category::find($model_5->id);
        $this->assertEquals(2, $model_5->getPosition());
        $model_2 = Category::find($model_2->id);
        $this->assertEquals(3, $model_2->getPosition());
        $model_3 = Category::find($model_3->id);
        $this->assertEquals(4, $model_3->getPosition());
        $model_4 = Category::find($model_4->id);
        $this->assertEquals(5, $model_4->getPosition());
    }

    /**
     * @test
     * @return void
     */
    public function updateWithDefinedTopPosition(): void
    {
        $model_1 = Category::create();
        $model_2 = Category::create();
        $model_3 = Category::create();
        $model_4 = Category::create();
        $model_5 = Category::create();

        $model_1->update(['position' => 5]);

        $model_2 = Category::find($model_2->id);
        $this->assertEquals(1, $model_2->getPosition());
        $model_3 = Category::find($model_3->id);
        $this->assertEquals(2, $model_3->getPosition());
        $model_4 = Category::find($model_4->id);
        $this->assertEquals(3, $model_4->getPosition());
        $model_5 = Category::find($model_5->id);
        $this->assertEquals(4, $model_5->getPosition());
        $model_1 = Category::find($model_1->id);
        $this->assertEquals(5, $model_1->getPosition());
    }

    /**
     * @test
     * @return void
     * @throws Exception
     */
    public function deleting(): void
    {
        $model_1 = Category::create();
        $model_2 = Category::create();

        $model_1->delete();
        $model_2 = Category::find($model_2->id);
        $this->assertEquals(1, $model_2->getPosition());
    }

    /**
     * @test
     * @return void
     */
    public function positionKeyNameProperty(): void
    {
        $model = CategoryCustomPositionKey::create();

        $this->assertEquals('dummy', $model->getPositionColumn());
        $this->assertEquals(1, $model->getPosition());
    }
}
