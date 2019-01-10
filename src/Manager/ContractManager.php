<?php

namespace Prexto\Manager;

use Prexto\Utils\Config;
use GuzzleHttp\Client;

class ContractManager
{
    /**
     * @var string $apiUrl
     */
    private $apiUrl;

    /**
     * @var string $tokenAuth
     */
    private $tokenAuth;

    /**
     * @var $client
     */
    protected $client;

    /**
     * @var string $contractId
     */
    protected $contractId;

    /**
     * @var array $headers
     */
    protected $headers = [];

    /**
     * @param string $contractId
     */
    public function __construct($contractId)
    {
        $this->apiUrl    = Config::getParameter('api_url');
        $this->tokenAuth = Config::getParameter('token_auth');

        $this->contractId = $contractId;

        $this->client = new Client([
            'base_uri' => $this->apiUrl
        ]);

        $this->headers = [
            'Authorization' => 'Bearer ' . $this->tokenAuth
        ];
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $data
     ]
     */
    protected function request($method, $uri, array $data = [])
    {
        $uri = sprintf('/api/contract%s', $uri);

        try {
            return $this->client->request($method, $uri, [
                'headers' => $this->headers,
                'json'    => $data
            ]);
        } catch (\Exception $ex) {
            throw new \Exception(sprintf('%s%s[%s] %s %s%s',
                $ex->getMessage(),
                PHP_EOL,
                $method,
                $uri,
                PHP_EOL,
                json_encode($data, JSON_PRETTY_PRINT)
            ));
        }
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function configurate(array $data = [])
    {
        if (!$data) {
            return [];
        }

        $uri = sprintf('/configuration/%s', $this->contractId);
        /*
        return $this->request('POST', $uri, [
            'json' => $data
        ]);*/
    }

    /**
     * @return array
     */
    public function getVariables()
    {
        $uri = sprintf('/variables/%s', $this->contractId);

        return $this->request('GET', $uri);
    }

    /**
     * @param string $participantId
     * @param array  $data
     *
     * @return array
     */
    public function setVariables($participantId, array $data)
    {
        if (!$data) {
            return;
        }

        $uri = sprintf('/variables/%s/%s', $this->contractId, $participantId);

        return $this->request('POST', $uri, [
            'json' => $data
        ]);
    }

    /**
     * @param string $participantId
     *
     * @return array
     */
    public function getParticipant($participantId)
    {
        $uri = sprintf('/participant/%s/%s', $this->contractId, $participantId);

        return $this->request('GET', $uri);
    }

    /**
     * @param string $participantId
     * @param array  $data
     *
     * @return array
     */
    public function setParticipant($participantId, array $data = [])
    {
        if (!$data) {
            return;
        }

        $uri = sprintf('/participant/%s/%s', $this->contractId, $participantId);

        return $this->request('POST', $uri, [
            'json' => $data
        ]);
    }

    /**
     * @return array
     */
    public function toSign()
    {
        return $this->request('POST', sprintf('/send/%s', $this->contractId));
    }
}
