<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ProduitApiController extends AbstractController
{

    /**
     * @Route("/AfficherProduitsMobile", name="AfficherProduitsMobile")
     */
    public function AfficherProduitsMobile(ProduitRepository $repository)
    {
        return $this->json($repository->findAll(),200,[],['groups'=>'post:read']);
    }

    /**
     * @Route("/DetailProduitMobile", name="DetailProduitMobile")
     */
    public function DetailProduitMobile(Request $request) {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Produit::class)->find($id);
        if($produit!=null ) {

            return $this->json($produit,200,[],['groups'=>'post:read']);

        }
        return new JsonResponse("ID Produit Invalide.");


    }


    /**
    @Route("/AjouterProduitMobile", name="AjouterProduitMobile")
     *
     */
    public function AjouterProduitMobile (Request $request): Response
    {

        $produit = new Produit();

        $em=$this->getDoctrine()->getManager();

        $nom=$request->query->get("nom");

        $produit->setnom($nom);

        $description=$request->query->get("description");

        $produit->setdescription($description);

        $prix=$request->query->get("prix");

        $produit->setPrix($prix);

        $type=$request->query->get("type");
        $produit->setType($type);

        $em->persist($produit);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $aj = $serializer->normalize($produit);
        return new JsonResponse($aj);

    }

    /**
    @Route("/SupprimerProduitMobile", name="SupprimerProduitMobile")
     *
     */
    public function SupprimerProduitMobile(Request $request) {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository(Produit::class)->find($id);
        if($produit!=null ) {
            $em->remove($produit);
            $em->flush();

            return new JsonResponse("Prdouit Supprime!", 200);
        }
        return new JsonResponse("ID Produit Invalide.");


    }

    /**
     * @Route ("/UpdateProduitMobile", name="UpdateProduitMobile")
     */
    public function UpdateProduitMobile(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $this->getDoctrine()->getManager()
            ->getRepository(Produit::class)
            ->find($request->get("id"));

        $produit->setnom($request->get("nom"));
        $produit->setdescription($request->get("description"));
        $produit->setprix($request->get("prix"));
        $produit->setType($request->get("type"));

        $em->persist($produit);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit);
        return new JsonResponse("Produit a ete modifiee avec success.");
    }
}

