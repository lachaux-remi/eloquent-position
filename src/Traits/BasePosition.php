<?php

namespace EloquentPosition\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * Trait BasePosition
 */
trait BasePosition
{
    /**
     * Stores the property values - prevents multiple calls of property_exists.
     */
    protected $optionCache = [];

    /**
     * Return the position group settings
     */
    public function getPositionGroup(): ?string
    {
        return $this->positionOption( "positionGroup", null );
    }

    /**
     * Returns the position property option
     */
    protected function positionOption(string $propertyName, $defaultValue = null)
    {
        if ( !isset( $this->optionCache[$propertyName] ) ) {
            if ( property_exists( $this, $propertyName ) ) {
                $value = $this->{$propertyName};
            } else {
                $value = $defaultValue;
            }

            $this->optionCache[$propertyName] = $value;
        }
        return $this->optionCache[$propertyName];
    }

    /**
     * Return the position
     *
     * @return null|int
     */
    public function getPosition(): ?int
    {
        return $this->{$this->getPositionColumn()};
    }

    /**
     * Returns the position column.
     */
    public function getPositionColumn(): string
    {
        return $this->positionOption( "positionColumn", "position" );
    }

    /**
     * Sets the position value
     */
    public function setPosition(?int $value): Model|BasePosition
    {
        $this->{$this->getPositionColumn()} = $value;
        return $this;
    }

    /**
     * Convert the position value to numeric (if not null)
     */
    protected function setPositionAttribute($value): void
    {
        $finaleValue = is_null( $value ) || $value === "" ? null : intval( $value );

        $this->attributes["position"] = $finaleValue;
    }
}