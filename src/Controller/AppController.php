<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class AppController extends AbstractController
{
    /**
     * @Route("/", name="HomePage")
     */
    public function index(Request $request): Response
    {
        $isLoggedIn = false;
        $session = $request->getSession();
        if ( $session->has('login')){
            $isLoggedIn = true;
        }
        return $this->render('base-front.html.twig', [
            'controller_name' => 'AppController',
            'isLoggedIn' => $isLoggedIn
        ]);
    }
}
