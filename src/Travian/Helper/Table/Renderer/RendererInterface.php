<?php

namespace Timpack\Travian\Helper\Table\Renderer;


use Symfony\Component\Console\Output\OutputInterface;

/**
 * Interface RendererInterface
 * @package Timpack\Travian\Helper\Table\Renderer
 * @link https://github.com/netz98/n98-magerun
 */
interface RendererInterface
{

    /**
     * @param OutputInterface $output
     * @param array           $rows headers are expected to be the keys of the first row.
     */
    public function render(OutputInterface $output, array $rows);

}