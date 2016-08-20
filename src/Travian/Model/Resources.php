<?php

namespace Timpack\Travian\Model;


use FluentDOM;
use FluentDOM\Element;
use Timpack\Travian\Helper\Mapper;
use Timpack\Travian\Helper\Translator;
use Timpack\Travian\Model\Build\UpgradeInfo;

class Resources extends AbstractModel
{

    protected $dataSource = 'dorf1.php';

    public function getResourceList()
    {
        $result = [];
        $mapper = new Mapper();
        $translator = new Translator();
        /** @var Element $childNode */
        foreach($this->data->find('#rx')->get()[0]->childNodes as $childNode) {
            if ($childNode->nodeName !== 'area' || !$childNode->getAttribute('alt')) {
                continue;
            }

            $alt = $childNode->getAttribute('alt');
            $href = $childNode->getAttribute('href');
            $title = $childNode->getAttribute('title');
            $titleDom = FluentDOM::QueryCss("<div>$title</div>", 'text/html5');

            $resourceField = new ResourceField();
            $upgradeInfo = new UpgradeInfo();

            $hrefMatches = [];
            preg_match("/build\.php\?id=([0-9]+)/", $href, $hrefMatches);

            $altMatches = [];
            preg_match_all("/([a-zA-Z\s]+) [a-zA-Z]+ ([0-9]+)/", $alt, $altMatches);

            $resourceField->buildId = (int) $hrefMatches[1];
            $resourceField->name = $translator->translate($altMatches[1][0]);
            $resourceField->level = (int) $altMatches[2][0];
            $resourceField->type = $mapper->mapResourceNameToType($resourceField->name);
            $resourceField->upgradeInfo = $upgradeInfo;

            $upgradeInfo->upgradeLevel = $resourceField->level + 1;
            $upgradeInfo->clay      = (int) ($titleDom->find('.resources.r1')->text());
            $upgradeInfo->lumber    = (int) ($titleDom->find('.resources.r2')->text());
            $upgradeInfo->iron      = (int) ($titleDom->find('.resources.r3')->text());
            $upgradeInfo->crop      = (int) ($titleDom->find('.resources.r4')->text());

            $result[] = $resourceField;
        }
        return $result;
    }


}