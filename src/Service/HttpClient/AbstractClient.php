<?php

namespace App\Service\HttpClient;

use App\Exception\ClientBadRequestException;
use App\Exception\ClientUnavailableException;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

abstract class AbstractClient
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client) 
    {
        $this->client = $client;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $options
     *
     * @throws BadRequestHttpException
     * @throws ClientUnavailableException
     *
     * @return ResponseInterface
     */
    public function requestApi(string $method, string $uri, array $options = []): ResponseInterface
    {
        try {
            return $this->client->request($method, $uri, $options);
        } catch (ClientException $exception) {
            throw new ClientBadRequestException($exception->getMessage());
        } catch (TransportExceptionInterface $exception) {
            throw new ClientUnavailableException(null, $exception->getMessage());
        }
    }
}
