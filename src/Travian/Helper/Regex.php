<?php

namespace Timpack\Travian\Helper;


class Regex
{

    public function matchSingle($pattern, $subject, $index = 1)
    {
        $matches = $this->matchMultiple($pattern, $subject);
        if ($matches === false) {
            return '';
        }
        return $matches[$index][0];
    }

    public function matchMultiple($pattern, $subject, &$matches = [])
    {
        return (preg_match_all($pattern, $subject, $matches) ? $matches : false);
    }

}