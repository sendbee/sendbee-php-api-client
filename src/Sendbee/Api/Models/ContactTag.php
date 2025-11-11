<?php


namespace Sendbee\Api\Models;


use Sendbee\Api\Support\Model;

/**
 * Class ContactTag
 * @package Sendbee\Api\Models
 *
 * @property string $id UUID
 * @property string $name tag name
 * @property bool   $editable whether tag is editable
 * @property bool   $disable_contact whether tag disables contact
 * @property array  $icons tag icons
 */
class ContactTag extends Model
{
    protected function getFieldSpecification(){
        return [
            'id'                => self::fieldUUID(),
            'name'              => self::fieldText(),
            'editable'          => self::fieldBoolean(),
            'disable_contact'   => self::fieldBoolean(),
            'icons'             => self::fieldArray(),
        ];
    }
}
