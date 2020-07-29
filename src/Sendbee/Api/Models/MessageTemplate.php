<?php


namespace Sendbee\Api\Models;


use Sendbee\Api\Support\Model;

/**
 * Class MessageTemplate
 * @package Sendbee\Api\Models
 *
 * @property string $id UUID
 * @property string $status Status
 * @property string $reject_reason Reject Reason
 * @property string $keyword Keyword
 * @property string $tags Tags
 * @property string $text Text
 * @property string $language Language
 * @property string $attachment Attachment
 */
class MessageTemplate extends Model
{
    protected function getFieldSpecification(){
        return [
            'id'            => self::fieldUUID(),
            'status'        => self::fieldText(),
            'reject_reason' => self::fieldText(),
            'keyword'       => self::fieldText(),
            'tags'          => self::fieldModelCollection(MessageTemplateTag::class),
            'text'          => self::fieldText(),
            'language'      => self::fieldText(),
            'attachment'    => self::fieldText(),
        ];
    }
}