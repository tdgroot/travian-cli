<?php

namespace Timpack\Travian;

class CommandRegistry
{

    /**
     * @var CommandRegistry
     */
    private static $instance;

    private $commands = [];

    private function __construct() { }

    public static function getInstance() : self
    {
        if (is_null(self::$instance)) {
            self::$instance = new CommandRegistry();
        }
        return self::$instance;
    }

    public function getCommands() : array
    {
        return $this->commands;
    }

    public function register($command) : self
    {
        $this->commands[] = $command;
        return $this;
    }

    public function unregister($command) : self
    {
        $this->commands = array_filter($this->commands, function ($value) use ($command) {
            return $value !== $command;
        });
        return $this;
    }

}