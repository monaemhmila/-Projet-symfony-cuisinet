<?php

namespace App\Controller;

use App\Entity\Promotion;
use App\Form\PromotionType;
use App\Repository\PromotionRepository;
use App\Service\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PromotionController extends AbstractController
{
    /**
     * @route("AfficherPromotions", name="AfficherPromotions")
     */
    public function AfficherPromotions(PromotionRepository $repository){

        $promotions=$repository->findAll();
        return $this->render('promotion/afficher.html.twig',
            ['promotions'=>$promotions ]);

    }

    /**
     * @route("/SupprimerPromotion/{id}",name="SupprimerPromotion")
     */
    function SupprimerPromotion($id, PromotionRepository $repository){

        $promotions=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($promotions);
        $em->flush();
        return $this->redirectToRoute('AfficherPromotions');

    }

    /**
     * @route("AjouterPromotion", name="AjouterPromotion")
     */
    function AjouterPromotion(Request $request){

        $promotion = new Promotion();
        $form=$this->createForm(PromotionType::class,$promotion);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($promotion);
            $em->flush();
            return  $this->redirectToRoute('AfficherPromotions');
        }
        return $this->render('promotion/ajouter.html.twig',[
            'form'=>$form->createView()
        ]);

    }

    /**
     * @route ("ModifierPromotion/{id}",name="ModifierPromotion")
     */
    function ModifierPromotion(PromotionRepository  $repository, $id, Request $request){

        $promotion=$repository->find($id);
        $form=$this->createForm(PromotionType::class, $promotion);
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("AfficherPromotions");
        }
        return $this->render('promotion/modifier.html.twig',[
            'form'=>$form->createView()
        ]);


    }
    /**
     * @Route("/MailPromotion", name="MailPromotion")
     */
    function MailPromotion(Mailer $mailer){

        $mailer->sendEmailProm('Wassim.khemiri@esprit.tn');
        $this->addFlash("success", "Promotion effectuée avec succès! Merci de consulter votre mail");
        return  $this->redirectToRoute('AfficherPromotions');
    }






}
