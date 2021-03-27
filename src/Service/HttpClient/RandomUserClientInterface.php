<?php

namespace App\Service\HttpClient;

/**
 * API Documentation : https://randomuser.me/documentation
 */
interface RandomUserClientInterface
{
    public const GET_RANDOM_USER_URI = 'https://randomuser.me/api/';

    public const GENDER_MALE = 'male';
    public const GENDER_FEMALE = 'female';
    public const PASSWORD_SPECIAL = 'special';
    public const PASSWORD_UPPER = 'upper';
    public const PASSWORD_LOWER = 'lower';
    public const PASSWORD_NUMBER = 'number';
    public const MAX_RESULT = 5000;

    public const AVAILABLE_GENDER = [
        self::GENDER_MALE,
        self::GENDER_FEMALE
    ];
    public const AVAILABLE_PASSWORD_CHARSET = [
        self::PASSWORD_SPECIAL,
        self::PASSWORD_UPPER,
        self::PASSWORD_LOWER,
        self::PASSWORD_NUMBER
    ];

    public function getRandomUser(string $gender): array;
    public function getRandomPassword(string $parameters): array;
    public function getManyRandomUser(int $result): array;
}