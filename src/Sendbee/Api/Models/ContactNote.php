<?php


namespace Sendbee\Api\Models;


use Sendbee\Api\Support\Model;

/**
 * Class ContactNote
 * @package Sendbee\Api\Models
 *
 * @property string $value note content
 */
class ContactNote extends Model
{
    protected function getFieldSpecification(){
        return [
            'value'             => self::fieldText(),
        ];
    }
}
