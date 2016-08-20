<?php

namespace Timpack\Travian\Helper;


class Mapper
{

    protected $resourceTypeMap = [
        'woodcutter' => 'lumber',
        'clay pit' => 'clay',
        'iron mine' => 'iron',
        'cropfield' => 'crop'
    ];

    public function mapResourceNameToType($name) : string
    {
        $name = strtolower($name);
        if (isset($this->resourceTypeMap[$name])) {
            return $this->resourceTypeMap[$name];
        }
        return $name;
    }

}