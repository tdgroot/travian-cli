<?php

namespace Timpack\Travian\Model;

use FluentDOM;
use FluentDOM\Query;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;
use Psr\Http\Message\ResponseInterface;

class AbstractModel
{

    /**
     * @var string
     */
    protected $dataSource = '/dorf1.php';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var Query
     */
    protected $data;

    public function __construct($load = true)
    {
        $cookieJar = new FileCookieJar(sys_get_temp_dir() . '/ttc.txt', true);
        $this->client = new Client(['base_uri' => 'http://ts3.travian.nl', 'cookies' => $cookieJar]);
        if ($load) {
            $this->load();
        }
    }

    public function load()
    {
        $this->response = $this->client->get($this->dataSource);
        $body = (string)$this->response->getBody();
        $this->data = FluentDOM::QueryCss($body, 'text/html5');
    }

}