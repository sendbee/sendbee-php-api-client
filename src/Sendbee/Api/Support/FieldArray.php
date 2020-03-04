<?php


namespace Sendbee\Api\Support;


class FieldArray
{
    protected $value;

    public function __construct($defaultValue = [])
    {
        $this->set($defaultValue);
    }
    
    public function get(){
        return $this->value;
    }
    public function set($values = []){

        if(is_array($values))
        {
            $this->value = $values;
        }
    }
    public function isValid(){
        return is_array($this->value);
    }
}