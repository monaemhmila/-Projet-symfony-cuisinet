<?php

namespace App\Controller;

use App\Entity\Livreur;
use App\Form\LivreurType;
use App\Repository\LivreurRepository;
use App\Service\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LivreurController extends AbstractController
{
    /**
     * @route("AfficherLivreurs", name="AfficherLivreurs")
     */
    public function AfficherLivreurs(LivreurRepository $repository){

        $Livreurs=$repository->findAll();
        return $this->render('Livreur/afficher.html.twig',
            ['Livreurs'=>$Livreurs ]);

    }

    /**
     * @route("/SupprimerLivreur/{id}",name="SupprimerLivreur")
     */
    function SupprimerLivreur($id, LivreurRepository $repository){

        $Livreurs=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($Livreurs);
        $em->flush();
        return $this->redirectToRoute('AfficherLivreurs');

    }

    /**
     * @route("AjouterLivreur", name="AjouterLivreur")
     */
    function AjouterLivreur(Request $request){

        $Livreur = new Livreur();
        $form=$this->createForm(LivreurType::class,$Livreur);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($Livreur);
            $em->flush();
            return  $this->redirectToRoute('AfficherLivreurs');
        }
        return $this->render('Livreur/ajouter.html.twig',[
            'form'=>$form->createView()
        ]);

    }

    /**
     * @route ("ModifierLivreur/{id}",name="ModifierLivreur")
     */
    function ModifierLivreur(LivreurRepository  $repository, $id, Request $request){

        $Livreur=$repository->find($id);
        $form=$this->createForm(LivreurType::class, $Livreur);
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("AfficherLivreurs");
        }
        return $this->render('Livreur/modifier.html.twig',[
            'form'=>$form->createView()
        ]);


    }
    /**
     * @Route("/MailLivreur", name="MailLivreur")
     */
    function MailLivreur(Mailer $mailer){

        $mailer->sendEmailProm('Wassim.khemiri@esprit.tn');
        $this->addFlash("success", "Livreur effectuée avec succès! Merci de consulter votre mail");
        return  $this->redirectToRoute('AfficherLivreurs');
    }






}
