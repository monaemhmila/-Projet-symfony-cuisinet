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
     * @Route("/ajoutMateriel", name="AjoutMateriel")
     */
    public function addproduits(Request $request): Response
    {
        $produits = new Materiel();
        $form = $this->createForm(MaterielType::class, $produits);
            $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            // $images= $form->get('imageP')->getData();
            // $fichier = md5(uniqid()) . '.' . $images->guessExtension();
            // $images->move($this->getParameter('upload_directory'), $fichier);
            // $produits->setImageP($fichier);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produits);
            $entityManager->flush();
            return $this->redirectToRoute('Show_materiel');
        }
        return $this->render("BACK/AjoutMateriel.html.twig", [
            "materielForm" => $form->createView(),
        ]);
    }

  /** 
    * @Route ("/Deletemateriel/{id}", name="delete_materiel")
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
        $produits = $repository->find($id);
        $form = $this->createForm(MaterielType::class, $produits);
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
        //        $produits->setImageP($newFilename);
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
