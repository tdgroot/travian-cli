<?php

namespace Timpack\Travian\Helper;


class Translator
{

    protected $translations = [
        'nl_NL' => [
            'aardemuur' => 'Earth Wall',
            'academie' => 'Academy',
            'ambassade' => 'Embassy',
            'bakkerij' => 'Bakery',
            'barakken' => 'Barracks',
            'drinkplaats' => 'Horse Drinking Through',
            'bouwplaats' => 'Building plot',
            'handelskantoor' => 'Trade Office',
            'heldenhof' => "Hero's Mansion",
            'hoofdgebouw' => 'Main Building',
            'houthakker' => 'Woodcutter',
            'ijzersmederij' => 'Iron Foundry',
            'graanakker' => 'Cropland',
            'graanmolen' => 'Grain Mill',
            'graansilo' => 'Granary',
            'groot pakhuis' => 'Great Warehouse',
            'grote barakken' => 'Great Barracks',
            'grote graansilo' => 'Great Granary',
            'grote stallen' => 'Great Stable',
            'ijzermijn' => 'Iron Mine',
            'klei-afgraving' => 'Clay Pit',
            'korenmolen' => 'Grain Mill',
            'marktplaats' => 'Marketplace',
            'pakhuis' => 'Warehouse',
            'paleis' => 'Palace',
            'palissade' => 'Palisade',
            'raadhuis' => 'Town Hall',
            'residentie' => 'Residence',
            'schuilplaats' => 'Cranny',
            'schatkamer' => 'Treasury',
            'smederij' => 'Smithy',
            'stadsmuur' => 'City Wall',
            'stallen' => 'Stable',
            'steenbakkerij' => 'Brickyard',
            'steenhouwerij' => 'Brickyard',
            'toernooiveld' => 'Tournament Square',
            'vallenzetter' => 'Trapper',
            'verzamelplaats' => 'Rally Point',
            'werkplaats' => 'Workshop',
            'zaagmolen' => 'Sawmill',
        ]
    ];

    public function translate($subject) : string
    {
        $searchKey = strtolower($subject);
        if (isset($this->translations['nl_NL'][$searchKey])) {
            return $this->translations['nl_NL'][$searchKey];
        }
        return $subject;
    }

}