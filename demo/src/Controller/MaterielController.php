<?php

namespace App\Controller;


use App\Entity\Materiel;
use App\Form\MaterielType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\MaterielRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
class MaterielController extends AbstractController
{
    /**
     * @Route("/materiel", name="app_materiel")
     */
    public function index(): Response
    {
        return $this->render('materiel/index.html.twig', [
            'controller_name' => 'MaterielController',
        ]);
    }


 /**
     * @Route("/Showmateriel", name="Show_materiel")
     */
    public function products()
{
    $materiels = $this->getDoctrine()->getRepository(Materiel::class)->findAll();

    return $this->render('back/show_materiel.html.twig', [
        "materiels" => $materiels,
    ]);
    
}


     /**
     * @Route("/mobile/materiel", name="materiel")
     */
    public function afficheProdMobile( NormalizerInterface $normalize) :Response
    {
        $materiels = $this->getDoctrine()->getRepository(Materiel::class)->findAll();
        $json = $normalize->normalize($materiels, 'json',['groups'=>['show_materiel']]);
        return new JsonResponse($json);
    }

/**
 * @Route ("/Ajoutermateriel")
 */
public function ajouterMaterieltmobile(Request $request): Response
{

    $Materiel = new Materiel();

    $em=$this->getDoctrine()->getManager();

    $Descmat=$request->query->get("Descmat");

    $Materiel->setDescmat($Descmat);

    $prix=$request->query->get("prix");
    
    $Materiel->setPrix($prix);

    $nom=$request->query->get("nom");
    $Materiel->setNom($nom);

    $em->persist($Materiel);
    $em->flush();

    $serializer = new Serializer([new ObjectNormalizer()]);
    $aj = $serializer->normalize($Materiel);
    return new JsonResponse($aj);

}


 /**
     * @Route("/ajoutMateriel", name="AjoutMateriel")
     */
    public function addmateriel(Request $request,\Swift_Mailer $mailer): Response
    {
        $materiel = new Materiel();
        $form = $this->createForm(MaterielType::class, $materiel);
            $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            // $images= $form->get('imageP')->getData();
            // $fichier = md5(uniqid()) . '.' . $images->guessExtension();
            // $images->move($this->getParameter('upload_directory'), $fichier);
            // $materiel->setImageP($fichier);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($materiel);
            $entityManager->flush();
            return $this->redirectToRoute('Show_materiel');
        }
        $em = $this->getDoctrine()->getManager();
        $materiels = $em->getRepository(materiel::class)->findAll();      
        foreach($materiels as $materiel) {
        $database = [$materiel->getNom(),$materiel->getPrix(),$materiel->getDescmat()]; 
        $namePng =implode(' ',[$materiel->getNom()]);
    } 
    $message = (new \Swift_Message('activation mail'))
    
    ->setFrom('monemehamila@gmail.com')
    ->setTo('monaem.hmila@esprit.tn')
    ->setBody($namePng )
    
    
    ;
    
    
        return $this->render("BACK/AjoutMateriel.html.twig", [
            "materielForm" => $form->createView(),
        ]);
    
    }


  /** 
    * @Route ("/DeleteMateriel/{id}", name="delete_materiel")
    */
    function Delete($id,MaterielRepository $rep){
        $classroom=$rep->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($classroom);
        $em->flush();
        return $this->redirectToRoute('Show_materiel');
    }



 /** 
    * @Route ("/UpdateMateriel/{id}", name="update_materiel")
    */

 
    function UpdateProd(MaterielRepository $repository,$id,Request $request)
    {
        $materiel = $repository->find($id);
        $form = $this->createForm(MaterielType::class, $materiel);
        $form->add('Update', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        
        //    $uploadedFile = $form['imageP']->getData();
        //    if ($uploadedFile)
        //    {
        //        $destination = $this->getParameter('upload_directory');
        //        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        //        $newFilename = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
        //        $uploadedFile->move(
        //            $destination,
        //            $newFilename
        //        );
        //        $materiel->setImageP($newFilename);
        //    }
           $em = $this->getDoctrine()->getManager();
           $em->flush();
           return $this->redirectToRoute('Show_materiel');
        }
        return $this->render('BACK/Updatemateriel.html.twig',
            [
                'materielForm' => $form->createView(),
            ]);
    }

}
