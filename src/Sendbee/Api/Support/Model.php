<?php


namespace Sendbee\Api\Support;


class Model
{
    public static function fieldBoolean(){
        return new FieldBoolean();
    }

    public static function fieldText(){
        return new FieldText();
    }

    public static function fieldDateTime(){
        // @todo: implement DateTime
        return new FieldText();
    }

    public static function fieldArray(){
        // @todo: implement DateTime
        return new FieldArray();
    }

    public static function fieldModel($itemClass){
        return new FieldModel($itemClass);
    }

    public static function fieldModelCollection($itemClass){
        return new FieldModelCollection($itemClass);
    }

    protected function getFieldSpecification(){
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
     * @throws DataException
     */
    public function __construct(array $attributes = [])
    {
        $this->buildAttributes();
        $this->fill($attributes);
    }

    protected function buildAttributes(){
        $this->attributes = $this->getFieldSpecification();
    }

    /**
     * Fill the model with an array of attributes.
     *
     * @param array $attributes
     * @return $this
     *
     * @throws DataException
     */
    public function fill(array $attributes)
    {

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
     * @throws DataException
     */
    public function setAttribute($key, $value)
    {
        if(!array_key_exists($key, $this->attributes))
        {
            throw new DataException("Field '{$key}' is not present on model.");
        }

        $model = $this->attributes[$key];
        $model->set($value, $key);

        if(!$model->isValid())
        {
            throw new DataException("Invalid value for field '{$key}', got " . print_r($value, true));
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
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (! $key) {
            return null;
        }

        if (array_key_exists($key, $this->attributes)) {
            $value = $this->attributes[$key]->get();
            return $value ? $value : null;
        }

        return null;
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
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
     * @throws DataException
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

}