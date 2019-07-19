<?php

namespace LachauxRemi\EloquentPosition\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * Trait BasePosition
 * @package LachauxRemi\EloquentPosition\Traits
 */
trait BasePosition
{
    /**
     * Stores the property values - prevents multiple calls of property_exists.
     *
     * @var array
     */
    protected $optionCache = [];

    /**
     * Returns the position column.
     *
     * @return string
     */
    public function getPositionColumn(): string
    {
        return $this->positionOption('positionColumn', 'position');
    }

    /**
     * Return the position group settings
     *
     * @return string|null
     */
    public function getPositionGroup(): ?string
    {
        return $this->positionOption('positionGroup', null);
    }

    /**
     * Return the position
     *
     * @return int|null
     */
    public function getPosition(): ?int
    {
        return $this->{$this->getPositionColumn()};
    }

    /**
     * Sets the position value
     *
     * @param int|null $value
     * @return Model|BasePosition
     */
    public function setPosition(?int $value)
    {
        $this->{$this->getPositionColumn()} = $value;
        return $this;
    }

    /**
     * Convert the position value to numeric (if not null)
     *
     * @param mixed $value
     * @return void
     */
    protected function setPositionAttribute($value): void
    {
        $finaleValue = is_null($value) || $value === '' ? null : intval($value);

        $this->attributes['position'] = $finaleValue;
    }

    /**
     * Returns the position property option
     *
     * @param string        $propertyName
     * @param mixed|null    $defaultValue
     * @return mixed
     */
    protected function positionOption(string $propertyName, $defaultValue = null)
    {
        if (!isset($this->optionCache[$propertyName])) {
            if (property_exists($this, $propertyName)) {
                $value = $this->{$propertyName};
            } else {
                $value = $defaultValue;
            }

            $this->optionCache[$propertyName] = $value;
        }
        return $this->optionCache[$propertyName];
    }
}
