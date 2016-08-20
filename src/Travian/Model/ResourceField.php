<?php

namespace Timpack\Travian\Model;


use Timpack\Travian\Model\Build\UpgradeInfo;

class ResourceField extends AbstractModel
{

    public function __construct()
    {
        parent::__construct(false);
    }

    /**
     * @var int
     */
    public $buildId;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $level;

    /**
     * @var UpgradeInfo
     */
    public $upgradeInfo;

}