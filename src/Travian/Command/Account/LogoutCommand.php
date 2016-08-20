<?php

namespace Timpack\Travian\Command\Account;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Timpack\Travian\Model\Account;

class LogoutCommand extends Command
{

    protected function configure()
    {
        $this->setName('account:logout')
            ->setDescription('Logout from current session');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $account = new Account();
        if ($account->logout()) {
            $output->writeln("<info>Successfully logged out</info>");
        } else {
            $output->writeln("Failed to logout");
        }
    }

}