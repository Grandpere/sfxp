<?php

namespace App\Service\HttpClient;

use App\Service\HttpClient\AbstractClient;
use Symfony\Component\HttpFoundation\Request;

class RandomUserClient extends AbstractClient implements RandomUserClientInterface
{  
    public function getRandomUser(string $gender = null): array
    {
        if (null === $gender) {
            $response = $this->requestApi(
                Request::METHOD_GET,
                self::GET_RANDOM_USER_URI, 
            );
    
            return $response->toArray();
        }

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
        throw new \InvalidArgumentException(sprintf('Invalid gender : %s, available genders : [%s, %s]', $gender, self::GENDER_MALE, self::GENDER_FEMALE));
    }

    public function getManyRandomUser(int $result = 1): array
    {
        if ($result > 5000) {
            throw new \InvalidArgumentException(sprintf('Results are limited to %d, your request : %d', self::MAX_RESULT, $result));
        }

        $response = $this->requestApi(
            Request::METHOD_GET, 
            self::GET_RANDOM_USER_URI, [
                'query' => [
                    'results' => $result
                ]
            ]
        );
        return $response->toArray();
    }

    public function getRandomUserSeed(string $seed): array
    {
        $response = $this->requestApi(
            Request::METHOD_GET, 
            self::GET_RANDOM_USER_URI, [
                'query' => [
                    'seed' => $seed
                ]
            ]
        );
        return $response->toArray();
    }

    public function getRandomPassword(string $parameters): array
    {
        $availablesCharsets = self::AVAILABLE_PASSWORD_CHARSET;
        $params = explode(",", $parameters);

        foreach ($params as $key => $param) {
            if (preg_match('/\d{1,2}(-\d{1,2})?/', $param, $matches)) {
                if (1 === count($matches)) {
                    $passwordSize = $matches[0];
                }
                elseif (2 === count($matches)) {
                    $passwordSize = ($matches[0] < $matches[1]) ? sprintf("%s-%s",$matches[0], $matches[1]) : $matches[0];
                }
            }
            elseif (!in_array($param, $availablesCharsets)) {
                throw new \InvalidArgumentException(sprintf('Invalid charset : %s, available charsets : [%s, %s, %s, %s]', $param, self::PASSWORD_SPECIAL, self::PASSWORD_UPPER, self::PASSWORD_LOWER, self::PASSWORD_NUMBER));
            }
        }
        $response = $this->requestApi(
            Request::METHOD_GET, 
            self::GET_RANDOM_USER_URI, [
                'query' => [
                    'password' => sprintf("%s,%s",implode(',', $params), $passwordSize)
                ]
            ]
        );
        return $response->toArray();
    }
}
