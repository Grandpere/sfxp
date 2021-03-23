<?php

namespace App\Service\HttpClient;

use Symfony\Component\HttpFoundation\Response;

interface RandomUserClientInterface
{
    public const GET_RANDOM_USER_URI = 'https://randomuser.me/api/';

    public const GENDER_MALE = 'male';
    public const GENDER_FEMALE = 'female';
    public const AVAILABLE_GENDER = [
        self::GENDER_MALE,
        self::GENDER_FEMALE
    ];

    public function getRandomUser(): array;
    public function getRandomUserByGender(string $gender): array;
}