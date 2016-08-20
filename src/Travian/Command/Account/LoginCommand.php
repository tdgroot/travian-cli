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
		// Try getting password from command line
		$password = $input->getOption('password');

		// Prompt if no password was passed
		if(!$password){
			$helper = $this->getHelper('question');

    		$question = new Question('Please enter your password: ');
    		$question->setValidator(function ($value) {
        		if (trim($value) == '') {
            		throw new \Exception('The password can not be empty');
        		}

				return $value;
    		});
    		$question->setHidden(true);
    		$question->setMaxAttempts(20);
    		$password = $helper->ask($input, $output, $question);
		}

        $username = $input->getArgument('username');
      
        $account = new Account();
        if ($account->isLoggedIn($username)) {
            $output->writeln('Already logged in with this username');
		} else {
		  	$loginSuccess = $account->login($username, $password);

		    if ($loginSuccess) {
                $output->writeln('<info>Successfully logged in</info>');
            } else {
                $output->writeln('Failed to login');
			}
		}
    }
}
