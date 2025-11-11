<?php


namespace Sendbee\Api\Models;


use Sendbee\Api\Support\Model;

/**
 * Class Contact
 * @package Sendbee\Api\Models
 *
 * @property string $id UUID
 * @property string $name contact name
 * @property string $phone contact phone
 * @property string $created_at creation timestamp in format "YYYY-MM-DD HH:MM:SS", example "2020-02-29 23:36:55"
 * @property string $modified_at modification timestamp
 * @property bool   $has_messaging_consent whether contact has messaging consent
 * @property array  $tags array of tags
 * @property string $status contact status
 * @property string $folder contact folder
 * @property array  $contact_fields array of contact fields
 * @property array  $notes array of notes
 */
class Contact extends Model
{
    protected function getFieldSpecification(){
        return [
            'id'                    => self::fieldUUID(),
            'name'                  => self::fieldText(),
            'phone'                 => self::fieldText(),
            'created_at'            => self::fieldDateTime(),
            'modified_at'           => self::fieldDateTime(),
            'has_messaging_consent' => self::fieldBoolean(),
            'tags'                  => self::fieldModelCollection(ContactTag::class),
            'status'                => self::fieldText(),
            'folder'                => self::fieldText(),
            'contact_fields'        => self::fieldModelCollection(ContactContactField::class),
            'notes'                 => self::fieldModelCollection(ContactNote::class),
        ];
    }
}
