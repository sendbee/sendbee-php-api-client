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
 * @property string $email contact e-mail address
 * @property string $created_at creation timestamp in format "YYYY-MM-DD HH:MM:SS", example "2020-02-29 23:36:55"
 * @property array  $tags array of tags
 * @property string $status contact status
 * @property string $folder contact folder
 * @property string $facebook_link contact facebook link
 * @property string $twitter_link contact twitter link
 * @property array  $contact_fields array of contact fields
 * @property array  $notes array of notes
 */
class Contact extends Model
{
    protected function getFieldSpecification(){
        return [
            'id'                => self::fieldUUID(),
            'name'              => self::fieldText(),
            'phone'             => self::fieldText(),
            'email'             => self::fieldText(),
            'created_at'        => self::fieldDateTime(),
            'tags'              => self::fieldModelCollection(ContactTag::class),
            'status'            => self::fieldText(),
            'folder'            => self::fieldText(),
            'facebook_link'     => self::fieldText(),
            'twitter_link'      => self::fieldText(),
            'contact_fields'    => self::fieldModelCollection(ContactContactField::class),
            'notes'             => self::fieldModelCollection(ContactNote::class),
        ];
    }
}
