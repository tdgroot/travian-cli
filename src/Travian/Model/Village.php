<?php

namespace Timpack\Travian\Model;


use FluentDOM;
use FluentDOM\Element;
use Timpack\Travian\Helper\Mapper;
use Timpack\Travian\Helper\Regex;
use Timpack\Travian\Helper\Translator;

class Village extends Model
{

    protected $dataSource = 'dorf2.php';

    /**
     * @var int
     */
    public $villageId;

    /**
     * @var string
     */
    public $name;

    /**
     * @inheritdoc
     */
    public function afterLoad()
    {
        /** @var Element $active */
        $active = $this->data->find('#sidebarBoxVillagelist')->find('.active')->get()[0];
        $href = $active->firstElementChild->getAttribute('href');
        $regex = new Regex();
        $id = $regex->matchSingle('/.*=([0-9]+).*/', $href);
        $this->villageId = (int) $id;
        $this->name = $regex->matchSingle('/\s*([0-9a-zA-Z\ ]+)/', $active->textContent);
    }

    public function getBuildingList($upgrades) : array
    {
        $result = [];
        $mapper = new Mapper();
        $translator = new Translator();
        $regex = new Regex();

        /** @var Element $childNode */
        foreach ($this->data->find('#clickareas')->get()[0]->childNodes as $childNode) {
            if ($childNode->nodeName !== 'area' || !$childNode->getAttribute('alt') || strpos($childNode->getAttribute('alt'),
                    '<') === false
            ) {
                continue;
            }

            $alt = $childNode->getAttribute('alt');
            $href = $childNode->getAttribute('href');
            $altDom = FluentDOM::QueryCss("<div>$alt</div>", 'text/html5');

            $construction = new Construction();
            $upgradeInfo = $construction->getUpgradeInfo();

            $construction->constructionId = (int)$regex->matchSingle("/build\.php\?id=([0-9]+)/", $href);
            $construction->name = $translator->translate(
                $regex->matchSingle("/^([a-zA-Z\s]+) <span class=\"level\">/", $alt)
            );
            $construction->level = (int)$regex->matchSingle("/([0-9]+)/", $altDom->find('.level')->text());

            if ($upgrades) {
                $construction->load();
            }

            $upgradeInfo->upgradeLevel = $construction->level + 1;
            $upgradeInfo->clay = (int)($altDom->find('.resources.r1')->text());
            $upgradeInfo->lumber = (int)($altDom->find('.resources.r2')->text());
            $upgradeInfo->iron = (int)($altDom->find('.resources.r3')->text());
            $upgradeInfo->crop = (int)($altDom->find('.resources.r4')->text());

            $result[] = $construction;
        }

        return $result;
    }

    public function getCurrentVillageId()
    {
        return $this->villageId;
    }

    public function switchTo($villageId) : bool
    {
        $villageId = (int) $villageId;
        if ($this->villageId !== $villageId) {
            $response = Client::getInstance()->get("dorf2.php?newdid=$villageId");
            $this->load($response);
        }
        return $this->villageId === $villageId;
    }

}