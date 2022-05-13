<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Promotion;
use App\Repository\PromotionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class PromotionApiController extends AbstractController
{

    /**
     * @Route("/AfficherPromotionMobile", name="AfficherPromotionMobile")
     */
    public function AfficherPromotionMobile(PromotionRepository $repository ,Request $request)
    {
        return $this->json($repository->findAll(),200,[],['groups'=>'post:read']);

      //  $produit_id = $request->get("produit");

      //  $em=$this->getDoctrine()->getManager();
        //$promotion = $em->getRepository(Promotion::class)->findBy(["produit" => $em->getRepository(Produit::class)->find($produit_id)]);
     //   return $this->json($promotion,200,[],['groups'=>'post:read']);
    }



    /**
    @Route("/AjouterPromotionMobile", name="AjouterPromotionMobile")
     *
     */
    public function AjouterPromotionMobile (Request $request): Response
    {

        $promotion = new Promotion();
        $produit_id = $request->get("produit");

        $em=$this->getDoctrine()->getManager();

        $promotion->setProduit($this->getDoctrine()->getManager()->getRepository(Produit::class)->find($produit_id));

        $pourcentage=$request->query->get("pourcentage");

        $promotion->setpourcentage($pourcentage);


        $em->persist($promotion);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $aj = $serializer->normalize($promotion);
        return new JsonResponse($aj);

    }

    /**
    @Route("/SupprimerPromotionMobile", name="SupprimerPromotionMobile")
     *
     */
    public function SupprimerPromotionMobile(Request $request) {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $promotion = $em->getRepository(Promotion::class)->find($id);
        if($promotion!=null ) {
            $em->remove($promotion);
            $em->flush();

            return new JsonResponse("Promotion Supprime!", 200);
        }
        return new JsonResponse("ID promotion Invalide.");


    }

    /**
     * @Route ("/UpdatePromotionMobile", name="UpdatePromotionMobile")
     */
    public function UpdatePromotionMobile(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $promotion = $this->getDoctrine()->getManager()
            ->getRepository(Promotion::class)
            ->find($request->get("id"));

        $promotion->setPourcentage($request->get("pourcentage"));


        $em->persist($promotion);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($promotion);
        return new JsonResponse("promotion a ete modifiee avec success.");
    }
}

