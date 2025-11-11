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
 * @property string $rejected_reason Rejected Reason (alias)
 * @property string $keyword Keyword
 * @property string $name Template Name
 * @property string $category Template Category
 * @property array  $tags Tags
 * @property array  $button_tags Button Tags
 * @property array  $buttons Buttons
 * @property string $text Text
 * @property string $language Language
 * @property string $attachment Attachment
 */
class MessageTemplate extends Model
{
    protected function getFieldSpecification(){
        return [
            'id'                => self::fieldUUID(),
            'status'            => self::fieldText(),
            'reject_reason'     => self::fieldText(),
            'rejected_reason'   => self::fieldText(),
            'keyword'           => self::fieldText(),
            'name'              => self::fieldText(),
            'category'          => self::fieldText(),
            'tags'              => self::fieldModelCollection(MessageTemplateTag::class),
            'button_tags'       => self::fieldModelCollection(MessageTemplateTag::class),
            'buttons'           => self::fieldModelCollection(MessageTemplateButton::class),
            'text'              => self::fieldText(),
            'language'          => self::fieldText(),
            'attachment'        => self::fieldText(),
        ];
    }
}
