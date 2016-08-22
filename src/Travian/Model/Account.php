<?php

namespace Timpack\Travian\Model;

use Psr\Http\Message\ResponseInterface;

class Account extends Model
{

    /**
     * @var ResponseInterface
     */
    protected $response;

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

        $loginResult = Client::getInstance()->post('dorf1.php', [
            'form_params' => $params,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:47.0) Gecko/20100101 Firefox/47.0'
            ]
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

}
