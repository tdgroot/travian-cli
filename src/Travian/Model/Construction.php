<?php

namespace Timpack\Travian\Model;


use FluentDOM\Element;
use Khill\Duration\Duration;
use Timpack\Travian\Helper\Regex;
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
        $clockCount = count($clocks);
        if ($clockCount === 1) {
            $this->upgradeInfo->upgradeTime = 1;
            $statusMessage = $this->data->find('.statusMessage')->text();
        } elseif ($clockCount > 0) {
            /** @var Element $upgradeTime */
            $upgradeTime = $clocks[0];
            $this->upgradeInfo->duration = new Duration($upgradeTime->textContent);;
        }
    }

    public function upgrade() : bool
    {
        $regex = new Regex();
        $checksum = $regex->matchSingle("/.*csum' : '([a-zA-Z0-9]+)'/", $this->responseBody);

        $queryParams = [
            'a' => $this->constructionId,
            'c' => $checksum
        ];

        $response = Client::getInstance()->get('dorf2.php', [
            'query' => $queryParams
        ]);

        $this->load($response);

        return false;
    }

    public function canUpgrade() : bool
    {
        return !$this->upgradeInfo->upgradeTime;
    }

    public function getUpgradeInfo() : Info
    {
        return $this->upgradeInfo;
    }

    public function getDataSource() : string
    {
        return "{$this->dataSource}?id={$this->constructionId}";
    }

}