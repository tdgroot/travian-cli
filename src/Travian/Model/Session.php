<?php

namespace Timpack\Travian\Model;


class Session
{

    const FILENAME = 'tts.txt';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var Session
     */
    private static $instance = null;

    /**
     * Session constructor.
     */
    private function __construct()
    {
        if (!$this->sessionFileExists()) {
            $this->touchSessionFile();
        }
        $fileContents = $this->getFileContents();
        $this->data = $this->unserializeData($fileContents);
    }

    public static function getInstance() : Session
    {
        if (is_null(self::$instance)) {
            self::$instance = new Session();
        }
        return self::$instance;
    }

    public function setData($key, $value, $force = true)
    {
        if (!isset($this->data[$key]) || $force === true) {
            $this->data[$key] = $value;
        }
    }

    public function getData($key, $default = false)
    {
        if (!isset($this->data[$key])) {
            return $default;
        }
        return $this->data[$key];
    }

    public function flushSession()
    {
        if ($this->removeSessionFile()) {
            $this->data = [];
            return true;
        }
        return false;
    }

    protected function unserializeData(string $fileContents) : array
    {
        if (empty($fileContents) || !is_string($fileContents)) {
            return [];
        }
        return unserialize($fileContents);
    }

    protected function serializeData(array $data) : string
    {
        return serialize($data);
    }

    protected function getFileContents() : string
    {
        return file_get_contents($this->getFilePath());
    }

    protected function setFileContents() : bool
    {
        return file_put_contents($this->getFilePath(), $this->serializeData($this->data));
    }

    protected function touchSessionFile() : bool
    {
        return touch($this->getFilePath());
    }

    protected function removeSessionFile() : bool
    {
        return unlink($this->getFilePath());
    }

    protected function sessionFileExists() : bool
    {
        return file_exists($this->getFilePath());
    }

    protected function getFilePath() : string
    {
        return $this->getTmpDir() . DIRECTORY_SEPARATOR . self::FILENAME;
    }

    protected function getTmpDir() : string
    {
        return sys_get_temp_dir();
    }

    public function __destruct()
    {
        $this->setFileContents();
    }

}