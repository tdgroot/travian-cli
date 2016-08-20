<?php

namespace Timpack\Travian\Model;


use Timpack\Travian\Model\Construction\Upgrade\Info;

class Construction extends Model
{

    /**
     * @var int
     */
    public $constructionId;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $level;

    /**
     * @var Info
     */
    public $upgradeInfo;

    public function __construct($buildingId = null)
    {
        $this->constructionId;
        $load = ($this->constructionId ? true : false);
        parent::__construct($load);
    }

    public function getDataSource() : string
    {
        return "{$this->dataSource}?id={$this->constructionId}";
    }

}