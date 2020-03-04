<?php


namespace Sendbee\Api\Support;


class FieldModelCollection
{
    protected $value;
    protected $modelClass;
    
    public function __construct($modelClass, $defaultValue = [])
    {
        $this->modelClass = $modelClass;
        $this->set($defaultValue);
    }
    
    public function get(){
        return $this->value;
    }
    public function set($values = []){

        if(is_array($values))
        {
            $models = [];
            foreach($values as $v)
            {
                $models[] = new $this->modelClass($v);
            }

            $this->value = $models;
        }
    }
    public function isValid(){
        return is_array($this->value);
    }
}