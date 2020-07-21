<?php


namespace Sendbee\Api\Models;


use Sendbee\Api\Support\Model;

/**
 * Class Message
 * @package Sendbee\Api\Models
 *
 * @property string $body Message body
 * @property string $media_type Message media type
 * @property string $media_url Media URL
 * @property string $status Message status
 * @property string $direction Message direction
 * @property string $sent_at Message sent at in format "YYYY-MM-DD HH:MM:SS", example "2020-02-29 23:36:55"
 */
class Message extends Model
{
    protected function getFieldSpecification(){
        return [
            'body'          => self::fieldText(),
            'media_type'    => self::fieldText(),
            'media_url'     => self::fieldText(),
            'status'        => self::fieldText(),
            'direction'     => self::fieldText(),
            'sent_at'       => self::fieldDateTime(),
        ];
    }
}