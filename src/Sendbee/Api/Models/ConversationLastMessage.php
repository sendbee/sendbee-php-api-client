<?php


namespace Sendbee\Api\Models;


use Sendbee\Api\Support\Model;

/**
 * Class ConversationLastMessage
 * @package Sendbee\Api\Models
 *
 * @property string $direction Last message direction
 * @property string $status Last message status
 * @property string $inbound_sent_at Last inbound message sent at time in format "YYYY-MM-DD HH:MM:SS", example "2020-02-29 23:36:55"
 * @property string $outbound_sent_at Last outbound message sent at time in format "YYYY-MM-DD HH:MM:SS", example "2020-02-29 23:36:55"
 */
class ConversationLastMessage extends Model
{
    protected function getFieldSpecification(){
        return [
            'direction'          => self::fieldText(),
            'status'             => self::fieldText(),
            'inbound_sent_at'    => self::fieldDateTime(),
            'outbound_sent_at'   => self::fieldDateTime(),
        ];
    }
}