<?php


namespace Sendbee\Api\Support;


class FieldModel
{
    protected $value;

    public function __construct($modelClass, $defaultValue = [])
    {
        $this->value = new $modelClass($defaultValue);
    }
    
    public function get(){
        return $this->value;
    }
    public function set($value = []){
        $this->value->fill($value);
    }
    public function isValid(){
        foreach ($this->value->getAttributes() as $field)
        {
            if(!$field->isValid())
            {
                return false;
            }
        }

        return true;
    }
}