<?php


namespace Sendbee\Api\Models;


use Sendbee\Api\Support\Model;

/**
 * Class Member
 * @package Sendbee\Api\Models
 *
 * @property string $id UUID
 * @property string $name Name
 * @property string $role Role
 * @property string $online Online
 * @property string $available Available
 */
class TeamMember extends Model
{
    protected function getFieldSpecification(){
        return [
            'id'        => self::fieldUUID(),
            'name'      => self::fieldText(),
            'role'      => self::fieldText(),
            'online'    => self::fieldText(),
            'available' => self::fieldText(),
        ];
    }
}