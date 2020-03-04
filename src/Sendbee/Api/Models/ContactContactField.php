<?php


namespace Sendbee\Api\Models;


use Sendbee\Api\Support\Model;

/**
 * Class ContactContactField
 *
 * @package Sendbee\Api\Models
 */
class ContactContactField extends Model
{
    protected function getFieldSpecification(){
        return [
            'key'                => self::fieldText(),
            'value'              => self::fieldText(),
        ];
    }
}
