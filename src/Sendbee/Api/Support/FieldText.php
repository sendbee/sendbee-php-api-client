<?php


namespace Sendbee\Api\Support;


class FieldText
{
    protected $value;
    public function __construct($defaultValue = '')
    {
        $this->set($defaultValue);
    }

    public function get(){
        return $this->value;
    }
    public function set($value){
        $this->value = strval($value);
    }
    public function isValid(){
        return is_string($this->value) || is_null($this->value);
    }
}