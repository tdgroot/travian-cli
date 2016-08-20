<?php

namespace Timpack\Travian\Model;


use FluentDOM\Element;

class Resources extends AbstractModel
{

    protected $dataSource = 'dorf1.php';

    public function getResourceField()
    {
        /** @var Element $childNode */
        foreach($this->data->find('#rx')->get()[0]->childNodes as $childNode) {
            if ($childNode->nodeName !== 'area' || !$childNode->getAttribute('alt')) {
                continue;
            }

            $alt = $childNode->getAttribute('alt');
            $title = $childNode->getAttribute('title');
        }

        /** @var Element $result */
//        foreach ($this->data->find('#content') as $result) {
//            foreach ($result->childNodes as $childNode) {
//                var_dump($childNode);
//                exit;
//            }
////            var_dump($result->find('area'));
//            if (strpos($result['nodeValue'], 'area') !== false) {
//                echo 'Woohoo';
//            }
//        };
    }


}