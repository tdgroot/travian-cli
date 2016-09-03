<?php

namespace Timpack\Travian\Model;

use Faker\Provider\UserAgent;
use Psr\Http\Message\ResponseInterface;

class Account extends Model
{

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var Session
     */
    protected $session;

    public function __construct($load = true)
    {
        parent::__construct($load);
        $this->session = Session::getInstance();
    }

    public function isLoggedIn($username = null) : bool
    {
        $loggedIn = ($this->data->find('.logout')->length > 0);
        if ($loggedIn && !is_null($username)) {
            if (!$this->getUsername() === $username) {
                $loggedIn = false;
            }
        }
        return $loggedIn;
    }

    public function login($username, $password) : bool
    {
        $params = [
            'name' => $username,
            'password' => $password,
            's1' => 'Login',
            'login' => time(),
            'w' => '1920:1080'
        ];

        $userAgent = UserAgent::userAgent();
        $session = Session::getInstance()->flushSession();

        $loginResult = Client::getInstance()->post('dorf1.php', [
            'form_params' => $params
        ]);

        $this->load();
        return $this->isLoggedIn($username);
    }

    public function logout() : bool
    {
        Client::getInstance()->get('logout.php');
        $this->load();
        return !$this->isLoggedIn();
    }

    public function getUsername() : string
    {
        return trim($this->data->find('.playerName')->text());
    }

    public function getSession() : Session
    {
        return $this->session;
    }

}
