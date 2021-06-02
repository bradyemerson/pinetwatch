<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UnifiService
{
    private LoggerInterface $logger;
    private HttpClientInterface $httpClient;

    private string $domain;
    private bool $useHttps;
    private string $username;
    private string $password;

    private $cookieAuth = false;

    public function __construct(LoggerInterface $logger, HttpClientInterface $httpClient, $domain, $useHttps, $username, $password)
    {
        $this->logger = $logger;
        $this->httpClient = $httpClient;

        $this->domain = $domain;
        $this->useHttps = $useHttps;
        $this->username = $username;
        $this->password = $password;
    }

    public function getActiveClients() : array
    {
        if (!$this->cookieAuth && !$this->login()) {
            $this->logger->error('UnifiService - getActiveClients() - No login token present.');
            return [];
        }

        $response = $this->httpClient->request(
            'GET',
            $this->getRootURL() . '/proxy/network/api/s/default/stat/sta',
            [
                'headers' => [
                    'cookie' => $this->cookieAuth
                ]
            ]
        );
        $data = $response->toArray();

        return $data['data'];
    }

    private function login() : bool
    {
        $login = $this->httpClient->request(
            'POST',
            $this->getRootURL() . '/api/auth/login',
            [
                'body' => [
                    'username' => $this->username,
                    'password' => $this->password
                ]
            ]
        );
        if ($login->getStatusCode() !== 200) {
            $this->logger->error('UnifiService - login() - Error logging into Unifi controller.', [
                'status_code' => $login->getStatusCode(),
                'message' => $login->getContent()
            ]);
            return false;
        }
        $this->cookieAuth = $login->getHeaders()['set-cookie'];
        return true;
    }

    private function getRootURL() : string
    {
        return ($this->useHttps ? 'https://' : 'http://') . $this->domain;
    }
}
