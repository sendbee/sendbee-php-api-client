<?php


namespace Sendbee\Api\Models;


use Sendbee\Api\Support\Model;

/**
 * Class ContactTag
 * @package Sendbee\Api\Models
 *
 * @property string $id UUID
 * @property string $name tag name
 */
class ContactTag extends Model
{
    protected function getFieldSpecification(){
        return [
            'id'                => self::fieldUUID(),
            'name'              => self::fieldText(),
        ];
    }
}
