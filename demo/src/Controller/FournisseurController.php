<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Include PhpSpreadsheet required namespaces
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Entity\Fournisseur;
use App\Form\FournisseurType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\FournisseurRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
class FournisseurController extends AbstractController
{
    /**
     * @Route("/fournisseur", name="app_fournisseur")
     */
    public function exel()
    {   
        $spreadsheet = new Spreadsheet();
        
        /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');
        $sheet->setTitle("My First Worksheet");
        
        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);
        
        // Create a Temporary file in the system
        $fileName = 'my_first_excel_symfony4.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        
        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);
        
        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
}
    public function index(): Response
    {
        
        return $this->render('fournisseur/index.html.twig', [
            'controller_name' => 'FournisseurController',
        ]);

    }


 /**
     * @Route("/Showfournisseur", name="Show_fournisseur")
     */
    public function products()
{
    $fournisseurs = $this->getDoctrine()->getRepository(Fournisseur::class)->findAll();

    return $this->render('back/show_fournisseur.html.twig', [
        "fournisseurs" => $fournisseurs,
    ]);
    
}




 /**
     * @Route("/ajoutFournisseur", name="AjoutFournisseur")
     */
    public function addproduits(Request $request): Response
    {
        $produits = new Fournisseur();
        $form = $this->createForm(FournisseurType::class, $produits);
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
            return $this->redirectToRoute('Show_fournisseur');
        }
        return $this->render("BACK/AjoutFournisseur.html.twig", [
            "fournisseurForm" => $form->createView(),
        ]);
        $spreadsheet = new Spreadsheet();
        
        /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');
        $sheet->setTitle("My First Worksheet");
        
        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);
        
        // Create a Temporary file in the system
        $fileName = 'my_first_excel_symfony4.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        
        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);
        
        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }

  /** 
    * @Route ("/DeleteFournisseur/{id}", name="delete_fournisseur")
    */
    function Delete($id,FournisseurRepository $rep){
        $classroom=$rep->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($classroom);
        $em->flush();
        return $this->redirectToRoute('Show_fournisseur');
    }



 /** 
    * @Route ("/UpdateFournisseur/{id}", name="update_fournisseur")
    */

 
    function UpdateProd(FournisseurRepository $repository,$id,Request $request)
    {
        $produits = $repository->find($id);
        $form = $this->createForm(FournisseurType::class, $produits);
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
           return $this->redirectToRoute('Show_fournisseur');
        }
        return $this->render('BACK/UpdateFournisseur.html.twig',
            [
                'fournisseurForm' => $form->createView(),
            ]);
    }


}
