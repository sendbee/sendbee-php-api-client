<?php


namespace Sendbee\Api\Models;


use Sendbee\Api\Support\Model;

/**
 * Class ServerMessage
 * @package Sendbee\Api\Models
 *
 * @property string $message message content
 */
class ServerMessage extends Model
{
    protected function getFieldSpecification(){
        return [
            'message'             => self::fieldText(),
        ];
    }
}
