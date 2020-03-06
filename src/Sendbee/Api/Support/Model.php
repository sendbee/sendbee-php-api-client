<?php


namespace Sendbee\Api\Support;


class Model
{
    /**
     * Creates a new Bool field container
     *
     * @return FieldBoolean
     */
    public static function fieldBoolean()
    {
        return new FieldBoolean();
    }

    public static function fieldInteger()
    {
        return new FieldInteger();
    }

    /**
     * Creates a new text field container
     *
     * @return FieldText
     */
    public static function fieldText()
    {
        return new FieldText();
    }

    /**
     * Creates a new UUID field container
     *
     * @return FieldText
     */
    public static function fieldUUID()
    {
        // @todo: implement UUID
        return new FieldText();
    }

    /**
     * Creates a new DateTime field container
     *
     * @return FieldText
     */
    public static function fieldDateTime()
    {
        // @todo: implement DateTime
        return new FieldText();
    }

    /**
     * Creates a new array field container
     *
     * @return FieldArray
     */
    public static function fieldArray()
    {
        return new FieldArray();
    }

    /**
     * Creates a new field container for the specified model
     *
     * @param $itemClass
     * @return FieldModel
     */
    public static function fieldModel($itemClass)
    {
        return new FieldModel($itemClass);
    }

    /**
     * Creates a new field container for an array of specified models
     *
     * @param $itemClass
     * @return FieldModelCollection
     */
    public static function fieldModelCollection($itemClass)
    {
        return new FieldModelCollection($itemClass);
    }

    /**
     * Get list of fields on the model
     *
     * @return array
     */
    protected function getFieldSpecification()
    {
        return [];
    }

    /**
     * List of fields and their specification
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Create a new model instance.
     *
     * @param array $attributes
     * @return void
     */
    public function __construct($attributes = [])
    {
        $this->buildAttributes();
        $this->fill($attributes);
    }

    protected function buildAttributes()
    {
        $this->attributes = $this->getFieldSpecification();
    }

    /**
     * Fill the model with an array of attributes.
     *
     * @param array $attributes
     * @return $this
     *
     */
    public function fill($attributes)
    {
        if (is_object($attributes)) {
            $attributes = (array)$attributes;
        }

        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    /**
     * Set a given attribute on the model.
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        if (!array_key_exists($key, $this->attributes)) {
            trigger_error("Field '{$key}' is not present on model (" . get_class($this) . ").");
            return $this;
        }

        $field = $this->attributes[$key];
        $field->set($value, $key);

        if (!$field->isValid()) {
            trigger_error("Invalid value for field '{$key}', got " . print_r($value, true));
        }

        return $this;
    }

    /**
     * Get all of the current attributes on the model.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Get an attribute from the model.
     *
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (!$key) {
            return null;
        }

        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key]->get();
        }

        return null;
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes on the model.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

}