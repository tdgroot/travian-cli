<?php

namespace Timpack\Travian;

class CommandRegistry
{

    /**
     * @var CommandRegistry
     */
    private static $instance;

    private $commands = [];

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new CommandRegistry();
        }
        return self::$instance;
    }

    public function getCommands()
    {
        return $this->commands;
    }

    public function register($command)
    {
        $this->commands[] = $command;
        return $this;
    }

    public function unregister($command)
    {
        $this->commands = array_filter($this->commands, function ($value) use ($command) {
            return $value !== $command;
        });
        return $this;
    }

}