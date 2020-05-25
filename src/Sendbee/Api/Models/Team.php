<?php


namespace Sendbee\Api\Models;


use Sendbee\Api\Support\Model;

/**
 * Class Team
 * @package Sendbee\Api\Models
 *
 * @property string $id UUID
 * @property string name Name
 * @property string members Keyword
 */
class Team extends Model
{
    protected function getFieldSpecification(){
        return [
            'id'        => self::fieldUUID(),
            'name'      => self::fieldText(),
            'members'   => self::fieldModelCollection(TeamMember::class),
        ];
    }
}