<?php


namespace Sendbee\Api\Models;


use Sendbee\Api\Support\Model;

/**
 * Class Message
 * @package Sendbee\Api\Models
 *
 * @property string $id Message ID
 * @property string $body Message body
 * @property string $media_type Message media type
 * @property string $media_url Media URL
 * @property string $status Message status
 * @property string $direction Message direction
 * @property string $sent_at Message sent at in format "YYYY-MM-DD HH:MM:SS", example "2020-02-29 23:36:55"
 * @property string $fail_reason Failure reason if message failed
 * @property string $action Action type
 * @property array  $meta_data Message metadata
 * @property string $from_user_id From user ID
 * @property string $to_user_id To user ID
 */
class Message extends Model
{
    protected function getFieldSpecification(){
        return [
            'id'            => self::fieldUUID(),
            'body'          => self::fieldText(),
            'media_type'    => self::fieldText(),
            'media_url'     => self::fieldText(),
            'status'        => self::fieldText(),
            'direction'     => self::fieldText(),
            'sent_at'       => self::fieldDateTime(),
            'fail_reason'   => self::fieldText(),
            'action'        => self::fieldText(),
            'meta_data'     => self::fieldArray(),
            'from_user_id'  => self::fieldUUID(),
            'to_user_id'    => self::fieldUUID(),
        ];
    }
}