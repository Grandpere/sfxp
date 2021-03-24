<?php

namespace App\Controller;

use App\Service\HttpClient\RandomUserClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RandomUserController extends AbstractController
{
    /**
     * @Route("/random/user", name="random_user")
     */
    public function randomUser(RandomUserClient $randomUserClient): Response
    {
        $randomUser = $randomUserClient->getRandomUser();
        dd($randomUser);
        return $this->render('random_user/index.html.twig', [
            'controller_name' => 'RandomUserController',
        ]);
    }

    /**
     * @Route("/random/user/{gender}", name="random_user_male", requirements={"gender"="[a-zA-Z]+"})
     */
    public function randomUserByGender(string $gender, RandomUserClient $randomUserClient): Response
    {
        $randomUser = $randomUserClient->getRandomUserByGender($gender);
        dd($randomUser);
    }
}
