<?php


namespace Sendbee\Api\Models;


use Sendbee\Api\Support\Model;

/**
 * Class ContactField
 * @package Sendbee\Api\Models
 *
 * @property string $id UUID
 * @property string $type Type
 * @property string $name Name
 */
class ContactField extends Model
{
    protected function getFieldSpecification(){
        return [
            'id'             => self::fieldUUID(),
            'type'           => self::fieldText(),
            'name'           => self::fieldText(),
            'options'        => self::fieldArray(),
        ];
    }
}

