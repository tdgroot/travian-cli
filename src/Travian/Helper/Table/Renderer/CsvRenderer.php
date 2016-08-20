<?php

namespace Timpack\Travian\Helper\Table\Renderer;


use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\StreamOutput;

/**
 * Class CsvRenderer
 * @package Timpack\Travian\Helper\Table\Renderer
 * @link https://github.com/netz98/n98-magerun
 */
class CsvRenderer implements RendererInterface
{

    /**
     * {@inheritdoc}
     */
    public function render(OutputInterface $output, array $rows)
    {
        // no rows - there is nothing to do
        if (!$rows) {
            return;
        }
        if ($output instanceof StreamOutput) {
            $stream = $output->getStream();
        } else {
            $stream = \STDOUT;
        }
        fputcsv($stream, array_keys(reset($rows)));
        foreach ($rows as $row) {
            fputcsv($stream, $row);
        }
    }

}