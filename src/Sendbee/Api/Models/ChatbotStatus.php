<?php


namespace Sendbee\Api\Models;


use Sendbee\Api\Support\Model;

/**
 * Class ChatbotStatus
 * @package Sendbee\Api\Models
 *
 * @property string $conversation_id UUID
 * @property bool $chatbot_active chatbot status
 */
class ChatbotStatus extends Model
{
    protected function getFieldSpecification(){
        return [
            'conversation_id'   => self::fieldUUID(),
            'chatbot_active'    => self::fieldBoolean(),
        ];
    }
}
