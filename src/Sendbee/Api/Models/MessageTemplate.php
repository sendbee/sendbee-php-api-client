<?php


namespace Sendbee\Api\Models;


use Sendbee\Api\Support\Model;

/**
 * Class MessageTemplate
 * @package Sendbee\Api\Models
 *
 * @property string $id UUID
 * @property string $approved Approved
 * @property string $keyword Keyword
 * @property string $tags Tags
 * @property string $text Text
 * @property string $language Language
 */
class MessageTemplate extends Model
{
    protected function getFieldSpecification(){
        return [
            'id'          => self::fieldUUID(),
            'approved'    => self::fieldBoolean(),
            'keyword'     => self::fieldText(),
            'tags'        => self::fieldModelCollection(MessageTemplateTag::class),
            'text'        => self::fieldText(),
            'language'    => self::fieldText(),

        ];
    }
}