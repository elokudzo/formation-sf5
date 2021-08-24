<?php

namespace App\Controller;

use App\Omdb\OmdbClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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
    public function search(Request $request, HttpClientInterface $httpClient):Response
    {
        $omdb = new OmdbClient($httpClient, '28c5b7b1','https://www.omdbapi.com');

        $keyword = $request->query->get('keyword', 'Sky');
        $movies   = $omdb->requestBySearch($keyword)['Search'];
        return $this->render('movie/search.html.twig',[
            'keyword'=> $keyword,
            'movies' => $movies,
        ]);
    }

    /**
     * @Route("/latest", name="movie_latest")
     */
    public function latest():Response
    {

        return $this->render('movie/latest.html.twig');
    }
}
