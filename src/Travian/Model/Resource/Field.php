<?php

namespace Timpack\Travian\Model\Resource;


use Timpack\Travian\Model\Construction;

class Field extends Construction
{

    /**
     * @var string
     */
    public $type;

    /**
     * @var double
     */
    public $unitsPerHour;


    public function startUpgrade()
    {
        return false;
    }

}