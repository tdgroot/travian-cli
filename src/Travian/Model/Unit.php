<?php

namespace Timpack\Travian\Model;


use FluentDOM\Element;
use Timpack\Travian\Helper\Mapper;
use Timpack\Travian\Helper\Regex;
use Timpack\Travian\Helper\Translator;

class Unit extends Model
{

    protected $dataSource = 'dorf1.php';

    public function getUnitList() : array
    {
        $result = [];
        $regex = new Regex();
        $mapper = new Mapper();
        $translator = new Translator();

        /** @var Element $childNode */
        foreach($this->data->find('#troops')->get()[0]->childNodes as $childNode){
            if ($childNode->nodeName == 'tbody'){
                /** @var Element $tr */
                foreach ($childNode->childNodes as $tr) {
                    if ($tr->nodeName !== 'tr') {
                        continue;
                    }
                    $nodeValue = trim($tr->nodeValue);
                    $matches = $regex->matchMultiple('/([0-9]+)[\s]+([\w\s]+)/', $nodeValue);
                    if (empty($matches)) {
                        continue;
                    }

                    $troop = new Troop();
                    $troop->amount = trim($matches[1][0]);
                    $troop->name = $translator->translate(trim($matches[2][0]));

                    $result[] = $troop;
                }
            }
        }

        return $result;
    }
}

class Troop
{
    public $name;

    public $amount;
}