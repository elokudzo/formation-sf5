<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/movie", name="movie")
 */

class MovieController extends AbstractController
{
    /**
     * @Route("/show/{id}", name="movie_show", requirements={"id": "\d+"})
     */
    public function show(): Response
    {
        return $this->render('movie/show.html.twig');
    }

    /**
     * @Route("/search", name="movie_search")
     */
    public function search():Response
    {

        return $this->render('movie/search.html.twig');
    }

    /**
     * @Route("/latest", name="movie_latest")
     */
    public function latest():Response
    {

        return $this->render('movie/latest.html.twig');
    }
}
