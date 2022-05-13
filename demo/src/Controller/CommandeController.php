<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeEditFormType;
use App\Form\CommandeType;
use App\Form\CommandeEditType;
use App\Repository\CommandeRepository;
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

class CommandeController extends AbstractController
{
    /**
     * @route("AfficherCommandes", name="AfficherCommandes")
     */
    public function AfficherCommandes(CommandeRepository $repository){

        $Commandes=$repository->findAll();
        return $this->render('Commande/afficher.html.twig',
            ['Commandes'=>$Commandes ]);

    }

    /**
     * @route("SupprimerCommande/{id}",name="SupprimerCommande")
     */
    function SupprimerCommande($id, CommandeRepository $repository){

        $Commande=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($Commande);
        $em->flush();
        return $this->redirectToRoute('AfficherCommandes');


    }

    /**
     * @route("/AjouterCommande", name="AjouterCommande")
     */
    function AjouterCommande(Request $request){

        $Commande = new Commande();
        $form=$this->createForm(CommandeType::class,$Commande);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file = $Commande->getPhoto();
            $uploads_directory = $this->getParameter('upload_directory');
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $uploads_directory,
                $fileName
            );
            $Commande->setPhoto($fileName);
            $em=$this->getDoctrine()->getManager();
            $em->persist($Commande);
            $em->flush();
            return  $this->redirectToRoute('AfficherCommandes');
        }
        return $this->render('Commande/ajouter.html.twig',[
            'form'=>$form->createView()
        ]);

    }

    /**
     * @route ("ModifierCommande/{id}",name="ModifierCommande")
     */
    function ModifierCommande(CommandeRepository  $repository, $id, Request $request){

        $Commande=$repository->find($id);
        $form=$this->createForm(CommandeEditFormType::class, $Commande);
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

                $Commande->setPhoto($fileName);
            }
            else
            {
                $Commande->setPhoto($Commande->getPhoto());
            }
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("AfficherCommandes");
        }
        return $this->render('Commande/modifier.html.twig',[
            'form'=>$form->createView()
        ]);

    }

    /**
     * @route("AfficherCommandesFront", name="AfficherCommandesFront")
     */
    public function AfficherCommandesFront(CommandeRepository $repository){

        $Commandes=$repository->findAll();
        return $this->render('Commande/AfficherFront.html.twig',
            ['Commandes'=>$Commandes ]);

    }

    /**
     * @param CommandeRepository $repository
     * @return Response
     * @route("/StatistiquesCommandes", name="StatistiquesCommandes")
     */
    public function StatistiquesCommandes(CommandeRepository $repository){

        {

            $Commandes=$repository->findAll();
            return $this->render('Commande/statistiques.html.twig',
                ['Commandes'=>$Commandes]);
        }


    }
    /**
     * @Route("/DownloadCommandesData", name="DownloadCommandesData")
     */
    public function DownloadCommandesData(CommandeRepository $repository)
    {
        $Commandes=$repository->findAll();

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
        $html = $this->renderView('Commande/download.html.twig',
            ['Commandes'=>$Commandes ]);


        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // On génère un nom de fichier
        $fichier = 'Tableau des Commandes.pdf';

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
