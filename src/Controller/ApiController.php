<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/movies", name="api")
     */
    public function index(): Response
    {
        $movies = [
            ['title' => 'Harry Poter'],
            ['title' => 'Gangs of London']
        ];

        return new JsonResponse($movies);
    }
}
