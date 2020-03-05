<?php


namespace Sendbee\Api\Support;


class FieldInteger
{
    protected $value;
    public function __construct($defaultValue = null)
    {
        $this->set($defaultValue);
    }

    public function get(){
        return $this->value;
    }
    public function set($value){
        $this->value = intval($value);
    }
    public function isValid(){
        return is_integer($this->value);
    }
}