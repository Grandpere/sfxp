<?php

namespace App\Controller;

use App\Service\HttpClient\RandomUserClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RandomUserController extends AbstractController
{
    /**
     * @Route("/random/user/gender/{gender}", name="random_user", requirements={"gender"="[a-z]+"})
     */
    public function randomUser(RandomUserClient $randomUserClient, ?string $gender = null): Response
    {
        $randomUser = $randomUserClient->getRandomUser($gender);
        dd($randomUser);
        return $this->render('random_user/index.html.twig', [
            'controller_name' => 'RandomUserController',
        ]);
    }

    /**
     * @Route("/random/user/result/{results}", name="many_random_users", requirements={"results"="\d+"})
     */
    public function manyRandomUser(RandomUserClient $randomUserClient, int $results = 1): Response
    {
        $randomUser = $randomUserClient->getManyRandomUser($results);
        dd($randomUser);
    }

    /**
     * @Route("/random/user/seed/{seed}", name="random_user_seed", requirements={"seed"="[\w|\d+]+"})
     */
    public function RandomUserSeed(RandomUserClient $randomUserClient, string $seed): Response
    {
        $randomUser = $randomUserClient->getRandomUserSeed($seed);
        dd($randomUser);
    }

    /**
     * @Route("/random/user/password/", name="random_password")
     */
    public function randomPassword(Request $request, RandomUserClient $randomUserClient): Response
    {
        // p requirements [a-z]{5,7}(,[a-z]{5,7}){0,3}(,\d{1,2}-\d{1,2})
        // https://regex101.com/r/zmFVpH/1/
        $parameters = $request->query->get('p');
        $randomPassword = $randomUserClient->getRandomPassword($parameters);
        dd($randomPassword);
    }
}
