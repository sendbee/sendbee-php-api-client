<?php


namespace Sendbee\Api\Models;


use Sendbee\Api\Support\Model;

/**
 * Class Conversation
 * @package Sendbee\Api\Models
 *
 * @property string $id UUID
 * @property string $folder folder
 * @property bool   $chatbot_active
 * @property string $platform
 * @property string $created_at creation timestamp in format "YYYY-MM-DD HH:MM:SS", example "2020-02-29 23:36:55"
 *
 * @property ConversationLastMessage $last_message
 * @property ConversationContact $contact
 */
class Conversation extends Model
{
    protected function getFieldSpecification(){
        return [
            'id'                => self::fieldText(),
            'folder'            => self::fieldText(),
            'chatbot_active'    => self::fieldBoolean(),
            'platform'          => self::fieldText(),
            'created_at'        => self::fieldDateTime(),
            'last_message'      => self::fieldModel(ConversationLastMessage::class),
            'contact'           => self::fieldModel(ConversationContact::class),
        ];
    }
}
