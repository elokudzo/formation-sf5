<?php

namespace App\Controller;

use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {

        $registerForm = $this->createForm(UserType::class);
        $registerForm->add('submit', SubmitType::class, [
            'label' => 'Create your Sensio TV Account'
        ]);

        $registerForm->handleRequest($request);

        if($registerForm->isSubmitted() && $registerForm->isValid()){
            $user = $registerForm->getData();

            $entityManager->persist($user);
            $entityManager->flush();
//
//            dump($user);
        }
        return $this->render('user/register.html.twig', [
            'register_form' => $registerForm->createView()
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(): Response
    {
        return $this->render('user/login.html.twig', [

        ]);
    }

}
