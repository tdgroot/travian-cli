<?php

namespace Timpack\Travian\Model;


use Timpack\Travian\Helper\Mapper;
use Timpack\Travian\Helper\Translator;
    
class Unit extends Model
{

    protected $dataSource = 'dorf1.php';

    public function getUnitList() : array
    {
        $result = [];
        $mapper = new Mapper();
        $translator = new Translator();

        foreach($this->data->find('#troops')->get()[0]->childNodes as $childNode){
            if ($childNode->nodeName == 'tbody'){
                $parts = preg_split('/\s+/', $childNode->textContent);

                $troop = new Troop();
                $troop->name = $parts[1];
                $troop->amount = $parts[2];
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