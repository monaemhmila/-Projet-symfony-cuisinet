<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitEditFormType;
use App\Form\ProduitType;
use App\Form\ProduitEditType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Dompdf\Dompdf;
use Dompdf\Options;

class ProduitController extends AbstractController
{
    /**
     * @route("AfficherProduits", name="AfficherProduits")
     */
    public function AfficherProduits(ProduitRepository $repository){

        $produits=$repository->findAll();
        return $this->render('produit/afficher.html.twig',
            ['produits'=>$produits ]);

    }

    /**
     * @route("SupprimerProduit/{id}",name="SupprimerProduit")
     */
    function SupprimerProduit($id, ProduitRepository $repository){

        $produit=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute('AfficherProduits');


    }

    /**
     * @route("/AjouterProduit", name="AjouterProduit")
     */
    function AjouterProduit(Request $request){

        $produit = new Produit();
        $form=$this->createForm(ProduitType::class,$produit);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file = $produit->getPhoto();
            $uploads_directory = $this->getParameter('upload_directory');
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $uploads_directory,
                $fileName
            );
            $produit->setPhoto($fileName);
            $em=$this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            return  $this->redirectToRoute('AfficherProduits');
        }
        return $this->render('produit/ajouter.html.twig',[
            'form'=>$form->createView()
        ]);

    }

    /**
     * @route ("ModifierProduit/{id}",name="ModifierProduit")
     */
    function ModifierProduit(ProduitRepository  $repository, $id, Request $request){

        $produit=$repository->find($id);
        $form=$this->createForm(ProduitEditFormType::class, $produit);
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $file = $form['photo']->getData();

            if($file)
            {
                $uploads_directory = $this->getParameter('upload_directory');
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $uploads_directory,
                    $fileName
                );

                $produit->setPhoto($fileName);
            }
            else
            {
                $produit->setPhoto($produit->getPhoto());
            }
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("AfficherProduits");
        }
        return $this->render('produit/modifier.html.twig',[
            'form'=>$form->createView()
        ]);

    }

    /**
     * @route("AfficherProduitsFront", name="AfficherProduitsFront")
     */
    public function AfficherProduitsFront(ProduitRepository $repository){

        $produits=$repository->findAll();
        return $this->render('produit/AfficherFront.html.twig',
            ['produits'=>$produits ]);

    }

    /**
     * @param ProduitRepository $repository
     * @return Response
     * @route("/StatistiquesProduits", name="StatistiquesProduits")
     */
    public function StatistiquesProduits(ProduitRepository $repository){

        {

            $produits=$repository->findAll();
            return $this->render('produit/statistiques.html.twig',
                ['produits'=>$produits]);
        }


    }
    /**
     * @Route("/DownloadProduitsData", name="DownloadProduitsData")
     */
    public function DownloadProduitsData(ProduitRepository $repository)
    {
        $produits=$repository->findAll();

        // On définit les options du PDF
        $pdfOptions = new Options();
        // Police par défaut
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);

        // On instancie Dompdf
        $dompdf = new Dompdf($pdfOptions);
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);
        $dompdf->setHttpContext($context);

        // On génère le html
        $html = $this->renderView('produit/download.html.twig',
            ['produits'=>$produits ]);


        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // On génère un nom de fichier
        $fichier = 'Tableau des Produits.pdf';

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => true
        ]);

        return new Response();
    }

    /**
     * Search action.
     * @Route("/search/{search}", name="search")
     * @param  Request               $request Request instance
     * @param  string                $search  Search term
     * @return Response|JsonResponse          Response instance
     */
    public function searchAction(Request $request, string $search)
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->render("search.html.twig");
        }

        if (!$searchTerm = trim($request->query->get("search", $search))) {
            return new JsonResponse(["error" => "Search term not specified."], Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        if (!($results = $em->getRepository(User::class)->findOneByEmail($searchTerm))) {
            return new JsonResponse(["error" => "No results found."], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            "html" => $this->renderView("search.ajax.twig", ["results" => $results]),
        ]);
    }





}
