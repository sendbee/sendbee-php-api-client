<?php


namespace Sendbee\Api\Models;


use Sendbee\Api\Support\Model;

/**
 * Class ConversationContact
 * @package Sendbee\Api\Models
 *
 * @property string $id UUID
 * @property string $name contact name
 * @property string $phone contact phone
 */
class ConversationContact extends Model
{
    protected function getFieldSpecification(){
        return [
            'id'                => self::fieldUUID(),
            'name'              => self::fieldText(),
            'phone'             => self::fieldText(),
        ];
    }
}