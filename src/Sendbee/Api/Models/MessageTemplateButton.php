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
 * @property array  $icon button icon (object)
 * @property string $action button action
 * @property string $flow_action flow action
 * @property string $navigate_screen navigate screen
 * @property string $flow_id flow ID
 * @property string $url_type URL type
 */
class MessageTemplateButton extends Model
{
    protected function getFieldSpecification(){
        return [
            'index'             => self::fieldInteger(),
            'type'              => self::fieldText(),
            'title'             => self::fieldText(),
            'value'             => self::fieldText(),
            'icon'              => self::fieldArray(),
            'action'            => self::fieldText(),
            'flow_action'       => self::fieldText(),
            'navigate_screen'   => self::fieldText(),
            'flow_id'           => self::fieldText(),
            'url_type'          => self::fieldText(),
        ];
    }
}
