<?php


namespace Sendbee\Api\Models;


use Sendbee\Api\Support\Model;

/**
 * Class SentMessage
 * @package Sendbee\Api\Models
 *
 * @property string $id Message UUID
 * @property string $status Message status
 */
class SentMessage extends Model
{
    protected function getFieldSpecification(){
        return [
            'id'                => self::fieldUUID(),
            'status'            => self::fieldText(),
        ];
    }
}
