<?php


namespace Sendbee\Api\Models;


use Sendbee\Api\Support\Model;

/**
 * Class MessageTemplateTag
 * @package Sendbee\Api\Models
 *
 * @property string $name tag name
 */
class MessageTemplateTag extends Model
{
    protected function getFieldSpecification(){
        return [
            'name'              => self::fieldText(),
        ];
    }
}
