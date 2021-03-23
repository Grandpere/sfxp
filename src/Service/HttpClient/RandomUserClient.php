<?php

namespace App\Service\HttpClient;

use App\Service\HttpClient\AbstractClient;
use Symfony\Component\HttpFoundation\Request;

class RandomUserClient extends AbstractClient implements RandomUserClientInterface
{  
    public function getRandomUser(): array
    {
        $response = $this->requestApi(
            Request::METHOD_GET,
            self::GET_RANDOM_USER_URI,
            // https://symfony.com/doc/current/http_client.html#making-requests
            // 'query' => [
            //     'token' => '...',
            //     'name' => '...',
            // ],
        );

        return $response->toArray();
    }

    public function getRandomUserByGender(string $gender): array
    {
        if (in_array($gender, self::AVAILABLE_GENDER)) {
            $response = $this->requestApi(
                Request::METHOD_GET, 
                self::GET_RANDOM_USER_URI, [
                    'query' => [
                        'gender' => $gender
                    ]
                ]
            );
            return $response->toArray();
        }
        throw new \InvalidArgumentException(sprintf('Invalid gender : %s', $gender));
    }
}
