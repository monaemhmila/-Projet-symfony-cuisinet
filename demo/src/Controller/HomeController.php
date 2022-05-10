<?php

namespace App\Controller;

use App\Repository\HebergementRepository;
use App\Repository\ProduitRepository;
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homeRedirect")
     */
    public function index(): Response
    {
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/home", name="home")
     */
    public function home()
    {
        // $produits=$repository->findAll();
        // $hebergements=$repoH->findAll();
        //
        //
        //
        //
        return $this->render('front/home.html.twig'
        // , 
        // [
        //     'produits' => $produits,
        //     'hebergements' => $hebergements,
        //     //
        //     //
        //     //
        //     //
        //     //

        // ]
    );
    }
}
