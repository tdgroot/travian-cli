<?php

namespace Timpack\Travian\Model;


use FluentDOM;
use FluentDOM\Element;
use Timpack\Travian\Helper\Mapper;
use Timpack\Travian\Helper\Regex;
use Timpack\Travian\Helper\Translator;
use Timpack\Travian\Model\Construction\Upgrade\Info;

class Village extends Model
{

    protected $dataSource = 'dorf2.php';

    public function getBuildingList() : array
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
            $upgradeInfo = new Info();

            $construction->constructionId = (int)$regex->matchSingle("/build\.php\?id=([0-9]+)/", $href);
            $construction->name = $translator->translate(
                $regex->matchSingle("/^([a-zA-Z\s]+) <span class=\"level\">/", $alt)
            );
            $construction->level = (int)$regex->matchSingle("/([0-9]+)/", $altDom->find('.level')->text());
            $construction->upgradeInfo = $upgradeInfo;

            $upgradeInfo->upgradeLevel = $construction->level + 1;
            $upgradeInfo->clay = (int)($altDom->find('.resources.r1')->text());
            $upgradeInfo->lumber = (int)($altDom->find('.resources.r2')->text());
            $upgradeInfo->iron = (int)($altDom->find('.resources.r3')->text());
            $upgradeInfo->crop = (int)($altDom->find('.resources.r4')->text());

            $result[] = $construction;
        }

        return $result;
    }

}