<?php

namespace Timpack\Travian\Model;

use FluentDOM;
use FluentDOM\Query;
use Psr\Http\Message\ResponseInterface;

class Model
{

    /**
     * @var string
     */
    protected $dataSource = '/dorf1.php';

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var string
     */
    protected $responseBody;

    /**
     * @var Query
     */
    protected $data;

    public function __construct($load = true)
    {
        if ($load) {
            $this->load();
        }
    }

    public function loadDataSource()
    {
        return Client::getInstance()->get($this->getDataSource());
    }

    public function load(ResponseInterface $response = null)
    {
        $this->response = $response ? $response : $this->loadDataSource();
        $this->responseBody = (string)$this->response->getBody();
        $this->data = FluentDOM::QueryCss($this->responseBody, 'text/html5');
        $this->afterLoad();
        return $this;
    }

    protected function afterLoad()
    {
    }

    /**
     * @return string
     */
    public function getDataSource() : string
    {
        return $this->dataSource;
    }

}