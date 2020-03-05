<?php


namespace Sendbee\Api\Models;


use Sendbee\Api\Support\Model;

/**
 * Class ContactContactField
 * @package Sendbee\Api\Models
 *
 * @property string $key contact field key
 * @property string $value contact field value
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
