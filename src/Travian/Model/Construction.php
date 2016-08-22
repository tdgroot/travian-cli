<?php

namespace Timpack\Travian\Model;


use FluentDOM\Element;
use Khill\Duration\Duration;
use Timpack\Travian\Model\Construction\Upgrade\Info;

class Construction extends Model
{

    protected $dataSource = 'build.php';

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

    public function __construct($load = false)
    {
        $this->upgradeInfo = new Info();
        parent::__construct($load);
    }

    protected function afterLoad()
    {
        $clocks = $this->data->find('.clocks')->get();
        if (count($clocks) === 1) {
            $this->upgradeInfo->upgradeTime = 1;
            $statusMessage = $this->data->find('.statusMessage')->text();
        }
        /** @var Element $upgradeTime */
        $upgradeTime = $clocks[0];
        $this->upgradeInfo->duration = new Duration($upgradeTime->textContent);;
    }

    public function getUpgradeInfo()
    {
        return $this->upgradeInfo;
    }

    public function getDataSource() : string
    {
        return "{$this->dataSource}?id={$this->constructionId}";
    }

}