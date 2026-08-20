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
 * @property string $whatsapp_user_id WhatsApp Business-scoped user ID (BSUID), example "US.13491208655302741918"
 */
class ConversationContact extends Model
{
    protected function getFieldSpecification(){
        return [
            'id'                => self::fieldUUID(),
            'name'              => self::fieldText(),
            'phone'             => self::fieldText(),
            'whatsapp_user_id'  => self::fieldText(),
        ];
    }
}