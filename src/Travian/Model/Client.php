<?php

namespace Timpack\Travian\Model;


use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Cookie\FileCookieJar;
use Psr\Http\Message\ResponseInterface;

class Client
{

    /**
     * @var GuzzleClient
     */
    private $guzzleClient;

    /**
     * @var Client
     */
    private static $instance;

    private function __construct()
    {
        $cookieJar = new FileCookieJar(sys_get_temp_dir() . '/ttc.txt', true);
        $this->guzzleClient = new GuzzleClient([
            'base_uri' => 'http://ts3.travian.nl',
            'cookies' => $cookieJar,
            'headers' => ['User-Agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:47.0) Gecko/20100101 Firefox/47.0']
        ]);
    }

    /**
     * @return Client
     */
    public static function getInstance() : self
    {
        if (is_null(self::$instance)) {
            self::$instance = new Client();
        }
        return self::$instance;
    }

    /**
     * @param $path
     * @param array $options
     * @return ResponseInterface
     */
    public function get($path, $options = [])
    {
        return $this->guzzleClient->get($path, $options);
    }

    /**
     * @param $path
     * @param array $options
     * @return mixed
     */
    public function post($path, $options = [])
    {
        return $this->guzzleClient->post($path, $options);
    }

}