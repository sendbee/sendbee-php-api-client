<?php


namespace Sendbee\Api\Models;


use Sendbee\Api\Support\Model;

/**
 * Class MemberTeam
 * @package Sendbee\Api\Models
 *
 * @property string $id UUID
 * @property string $name Name
 */
class MemberTeam extends Model
{
    protected function getFieldSpecification(){
        return [
            'id'        => self::fieldUUID(),
            'name'      => self::fieldText(),
        ];
    }
}
