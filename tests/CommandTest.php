<?php

namespace LachauxRemi\EloquentPosition\Tests;

use LachauxRemi\EloquentPosition\Tests\Models\Category;
use LachauxRemi\EloquentPosition\Tests\Models\CategoryNoPosition;
use LachauxRemi\EloquentPosition\Tests\Models\CategoryWithParent;

class CommandTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function usingPosition(): void
    {
        $model_1 = CategoryNoPosition::create();
        CategoryNoPosition::create(['position' => 5]);
        CategoryNoPosition::create(['position' => 10]);
        $model_4 = CategoryNoPosition::create(['position' => 15]);

        $this->artisan('model:position ' . str_replace('\\', '\\\\', Category::class))
            ->assertExitCode(0);

        $model_1 = Category::find($model_1->id);
        $this->assertEquals(1, $model_1->getPosition());
        $model_4 = Category::find($model_4->id);
        $this->assertEquals(4, $model_4->getPosition());
    }

    /**
     * @test
     * @return void
     */
    public function usingPositionGroup(): void
    {
        $model_1 = CategoryNoPosition::create();
        CategoryNoPosition::create(['parent_id' => $model_1->getKey(), 'position' => 5]);
        $model_1_3 = CategoryNoPosition::create(['parent_id' => $model_1->getKey(), 'position' => 10]);
        $model_1_3_1 = CategoryNoPosition::create(['parent_id' => $model_1_3->getKey(), 'position' => 15]);

        $this->artisan('model:position ' . str_replace('\\', '\\\\', CategoryWithParent::class));

        $model_1_3 = CategoryWithParent::find($model_1_3->id);
        $this->assertEquals(2, $model_1_3->getPosition());
        $model_1_3_1 = CategoryWithParent::find($model_1_3_1->id);
        $this->assertEquals(1, $model_1_3_1->getPosition());
    }

    /**
     * @test
     * @return void
     */
    public function noUsingPosition(): void
    {
        $this->artisan('model:position ' . str_replace('\\', '\\\\', CategoryNoPosition::class))
            ->expectsOutput("Model " . CategoryNoPosition::class . " is not using Position trait")
            ->assertExitCode(0);
    }
}
