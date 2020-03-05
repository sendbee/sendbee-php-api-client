<?php


namespace Sendbee\Api\Transport;


use Sendbee\Api\Support\Model;

/**
 * Class ResponseMeta
 * @package Sendbee\Api\Transport
 *
 * @property string $total Total
 * @property string $to Items To
 * @property string $from Items From
 * @property string $per_page Per Page
 * @property string $last_page Last Page
 * @property array  $current_page Current Page
 */
class ResponseMeta extends Model
{
    protected function getFieldSpecification(){
        return [
            'total'             => self::fieldInteger(),
            'to'                => self::fieldInteger(),
            'from'              => self::fieldInteger(),
            'per_page'          => self::fieldInteger(),
            'last_page'         => self::fieldInteger(),
            'current_page'      => self::fieldInteger(),
        ];
    }
}
