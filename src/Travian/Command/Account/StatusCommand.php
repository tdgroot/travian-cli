<?php

namespace Timpack\Travian\Command\Account;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Timpack\Travian\Model\Account;

class StatusCommand extends Command
{

    public function configure()
    {
        $this->setName('account:status')
            ->setDescription('Get current account status');

        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new OutputFormatterStyle('red');
        $output->getFormatter()->setStyle('negative', $style);

        $account = new Account();
        $output->write('Logged in: ');
        if ($account->isLoggedIn()) {
            $output->writeln('<info>Yes</info>');
        } else {
            $output->writeln('<negative>No</negative>');
            return;
        }
        $output->writeln('Username: ' . $account->getUsername());
        $output->writeln('UserAgent: ' . $account->getSession()->getData('userAgent'));
    }

}