<?php


namespace Sendbee\Api\Transport;


use Sendbee\Api\Support\Model;

/**
 * Class ResponseError
 * @package Sendbee\Api\Transport
 *
 * @property string $detail Details of error
 * @property string $type Type of error
 */
class ResponseError extends Model
{
    protected function getFieldSpecification(){
        return [
            'detail'             => self::fieldText(),
            'type'               => self::fieldText(),
        ];
    }
}
