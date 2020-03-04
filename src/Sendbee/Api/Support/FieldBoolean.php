<?php


namespace Sendbee\Api\Support;


class FieldBoolean
{
    protected $value;
    public function __construct($defaultValue = false)
    {
        $this->set($defaultValue);
    }

    public function get(){
        return $this->value;
    }
    public function set($value){
        $this->value = boolval($value);
    }
    public function isValid(){
        return is_bool($this->value);
    }
}