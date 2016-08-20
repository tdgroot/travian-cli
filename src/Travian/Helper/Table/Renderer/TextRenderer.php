<?php

namespace Timpack\Travian\Helper\Table\Renderer;


use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableStyle;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TextRenderer
 * @package Timpack\Travian\Helper\Table\Renderer
 * @link https://github.com/netz98/n98-magerun
 */
class TextRenderer implements RendererInterface
{

    /**
     * @param OutputInterface $output
     * @param array           $rows headers are expected to be the keys of the first row.
     */
    public function render(OutputInterface $output, array $rows)
    {
        $table = new Table($output);
        $table->setStyle(new TableStyle());
        $table->setHeaders(array_keys($rows[0]));
        $table->setRows($rows);
        $table->render();
    }

}