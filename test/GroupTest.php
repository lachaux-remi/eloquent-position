<?php

namespace EloquentPosition\Test;

use EloquentPosition\Test\Models\CategoryWithParent;

/**
 * Class GroupTest
 */
class GroupTest extends TestCase
{
    /** @test */
    public function groupPositionUpdateAndSetLastPosition(): void
    {
        $model_1 = CategoryWithParent::create();
        $model_1_1 = CategoryWithParent::create( [ "parent_id" => $model_1->getKey() ] );
        $model_1_2 = CategoryWithParent::create( [ "parent_id" => $model_1->getKey() ] );

        $model_2 = CategoryWithParent::create();
        $model_2_1 = CategoryWithParent::create( [ "parent_id" => $model_2->getKey() ] );
        $this->assertEquals( 1, $model_2_1->getPosition() );

        $model_1_1->update( [ "parent_id" => $model_2->getKey(), "position" => null ] );

        $model_1_1 = CategoryWithParent::find( $model_1_1->getKey() );
        $this->assertEquals( $model_2->getKey(), $model_1_1->parent_id );
        $this->assertEquals( 2, $model_1_1->getPosition() );

        $model_1_2 = CategoryWithParent::find( $model_1_2->getKey() );
        $this->assertEquals( 1, $model_1_2->getPosition() );
    }

    /** @test */
    public function groupPositionUpdateAndSetPosition(): void
    {
        $model_1 = CategoryWithParent::create();
        $model_1_1 = CategoryWithParent::create( [ "parent_id" => $model_1->getKey() ] );

        $model_2 = CategoryWithParent::create();
        CategoryWithParent::create( [ "parent_id" => $model_2->getKey() ] );
        $model_2_2 = CategoryWithParent::create( [ "parent_id" => $model_2->getKey() ] );
        $model_2_3 = CategoryWithParent::create( [ "parent_id" => $model_2->getKey() ] );

        $model_1_1->update( [ "parent_id" => $model_2->getKey(), "position" => 2 ] );

        $model_1_1 = CategoryWithParent::find( $model_1_1->getKey() );
        $this->assertEquals( 2, $model_1_1->getPosition() );
        $model_2_2 = CategoryWithParent::find( $model_2_2->getKey() );
        $this->assertEquals( 3, $model_2_2->getPosition() );
        $model_2_3 = CategoryWithParent::find( $model_2_3->getKey() );
        $this->assertEquals( 4, $model_2_3->getPosition() );
    }

    /** @test */
    public function groupPositionUpdateAndSetExcessivePosition(): void
    {
        $model_1 = CategoryWithParent::create();
        $model_1_1 = CategoryWithParent::create( [ "parent_id" => $model_1->getKey() ] );

        $model_2 = CategoryWithParent::create();
        CategoryWithParent::create( [ "parent_id" => $model_2->getKey() ] );

        $model_1_1->update( [ "parent_id" => (string) $model_2->getKey(), "position" => (string) 5 ] );

        $model_1_1 = CategoryWithParent::find( $model_1_1->getKey() );
        $this->assertEquals( 2, $model_1_1->getPosition() );
    }

    /** @test */
    public function fixUpdateWithParentKeyIsString(): void
    {
        $model_1 = CategoryWithParent::create();
        $model_1_1 = CategoryWithParent::create( [ "parent_id" => $model_1->getKey() ] );
        $model_1_2 = CategoryWithParent::create( [ "parent_id" => $model_1->getKey() ] );

        $model_1_1->update( [ "parent_id" => (string) $model_1->getKey(), "position" => null ] );

        $model_1_2 = CategoryWithParent::find( $model_1_2->id );
        $this->assertEquals( 1, $model_1_2->getPosition() );
        $model_1_1 = CategoryWithParent::find( $model_1_1->id );
        $this->assertEquals( 2, $model_1_1->getPosition() );
    }

    /** @test */
    public function fixMoveWithParentKeyIsStringAndCondition(): void
    {
        $model_1 = CategoryWithParent::create();
        $model_1_1 = CategoryWithParent::create( [ "parent_id" => $model_1->getKey() ] );
        $model_1_2 = CategoryWithParent::create( [ "parent_id" => $model_1->getKey() ] );

        $model_2 = CategoryWithParent::create();
        $model_2_1 = CategoryWithParent::create( [ "parent_id" => $model_2->getKey() ] );

        $model_1_1->update( [ "parent_id" => $model_2->getKey(), "position" => 1 ] );

        $model_1_2 = CategoryWithParent::find( $model_1_2->id );
        $this->assertEquals( 1, $model_1_2->getPosition() );

        $model_1_1 = CategoryWithParent::find( $model_1_1->id );
        $this->assertEquals( $model_2->getKey(), $model_1_1->parent_id );
        $this->assertEquals( 1, $model_1_1->getPosition() );
        $model_2_1 = CategoryWithParent::find( $model_2_1->id );
        $this->assertEquals( 2, $model_2_1->getPosition() );
    }

    /** @test */
    public function deleting(): void
    {
        $model_1 = CategoryWithParent::create();
        $model_1_1 = CategoryWithParent::create( [ "parent_id" => $model_1->getKey() ] );
        $model_1_2 = CategoryWithParent::create( [ "parent_id" => $model_1->getKey() ] );

        $model_1_1->delete();
        $model_1_2 = CategoryWithParent::find( $model_1_2->getKey() );
        $this->assertEquals( 1, $model_1_2->getPosition() );
    }
}