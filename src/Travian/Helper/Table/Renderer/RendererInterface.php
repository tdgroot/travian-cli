<?php

namespace Timpack\Travian\Helper\Table\Renderer;


use Symfony\Component\Console\Output\OutputInterface;

interface RendererInterface
{

    /**
     * @param OutputInterface $output
     * @param array           $rows headers are expected to be the keys of the first row.
     */
    public function render(OutputInterface $output, array $rows);

}