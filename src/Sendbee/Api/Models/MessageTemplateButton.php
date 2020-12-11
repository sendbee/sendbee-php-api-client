<?php


namespace Sendbee\Api\Models;


use Sendbee\Api\Support\Model;

/**
 * Class MessageTemplateButton
 * @package Sendbee\Api\Models
 *
 * @property integer $index index
 * @property string $type type
 * @property string $title title
 * @property string $value value
 */
class MessageTemplateButton extends Model
{
    protected function getFieldSpecification(){
        return [
            'index' => self::fieldInteger(),
            'type'  => self::fieldText(),
            'title' => self::fieldText(),
            'value' => self::fieldText(),
        ];
    }
}
