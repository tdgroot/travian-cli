<?php

namespace Timpack\Travian\Command\Account;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Timpack\Travian\Model\Account;

class LoginCommand extends Command
{

    public function configure()
    {
        $this->setName('account:login')
            ->setDescription('Login using your credentials')
            ->addArgument('username', InputArgument::REQUIRED, 'Username')
            ->addOption('password', 'p', InputArgument::OPTIONAL, "User's password");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $password = $input->getOption('password');

        $account = new Account();
        if ($account->isLoggedIn($username)) {
            throw new LogicException('Already logged in with this username.');
        }

        if (!$password) {
            /** @var QuestionHelper $questionHelper */
            $questionHelper = $this->getHelper('question');
            $question = new Question('Password: ');
            $question->setValidator(function ($password) {
                if (empty($password)) {
                    throw new InvalidArgumentException('No password entered, please try again.');
                }
            });
            $password = $questionHelper->ask($input, $output, $question);
        }

        $loginSuccess = $account->login($username, $password);
        if ($loginSuccess) {
            $output->writeln("<info>Successfully logged in</info>");
        } else {
            $output->writeln("Failed to login");
        }
    }

}