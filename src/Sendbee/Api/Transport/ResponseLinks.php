<?php


namespace Sendbee\Api\Transport;


use Sendbee\Api\Support\Model;

/**
 * Class ResponseLinks
 * @package Sendbee\Api\Transport
 *
 * @property string $first URI for first page
 * @property string $last URI for last page
 * @property string $next URI for next page
 * @property string $prev URI for previous page
 */
class ResponseLinks extends Model
{
    protected function getFieldSpecification(){
        return [
            'first'    => self::fieldText(),
            'last'     => self::fieldText(),
            'next'     => self::fieldText(),
            'prev'     => self::fieldText(),
        ];
    }
}
