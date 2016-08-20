<?php

namespace Timpack\Travian\Helper;


class Translator
{

    protected $translations = [
        'nl_NL' => [
            'afgraving' => 'Clay Pit',
            'houthakker' => 'Woodcutter',
            'graanakker' => 'Cropland',
            'ijzermijn' => 'Iron Mine',
        ]
    ];

    public function translate($subject)
    {
        $searchKey = strtolower($subject);
        if (isset($this->translations['nl_NL'][$searchKey])) {
            return $this->translations['nl_NL'][$searchKey];
        }
        return $searchKey;
    }

}