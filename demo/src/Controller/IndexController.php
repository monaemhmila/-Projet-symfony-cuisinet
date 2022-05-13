<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Include PhpSpreadsheet required namespaces
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Entity\Materiel;
use App\Form\MaterielType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\MaterielRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Margin\Margin;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
class IndexController extends AbstractController{
        /**
     * @var BuilderInterface
     */
    protected $builder;

    public function __construct(BuilderInterface $builder)
    {
        $this->builder = $builder;
    }    
    /**
     * @Route("/exel")
     */
    public function exel()
    {   
        $spreadsheet = new Spreadsheet();
        
        /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
        $sheet = $spreadsheet->getActiveSheet();
        $em = $this->getDoctrine()->getManager();
        $materiels = $em->getRepository(materiel::class)->findAll();
        $i = 'A1';
        $B = 'B1';
        foreach($materiels as $materiel) {
            $database = [$materiel->getNom(),$materiel->getPrix(),$materiel->getDescmat()];
            $sheet  ->fromArray( $database, NULL, $i ); 
            $i++;
            $url = json_encode([$materiel->getNom(),$materiel->getIdmat(),$materiel->getIdFor()]) ;
                    //generate name
            $namePng =implode(' ',[$materiel->getNom()]);
        }          
        $sheet->setCellValue('B11', '=SUM(B1:B10)');
        $sheet->setCellValue('A11', 'prix total=');       
        $writer = new Xlsx($spreadsheet);
        
        // Create a Temporary file in the system
        $fileName = 'materielexel.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        
        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);
               // In this case, we want to write the file in the public directory
               $publicDirectory =  dirname(__DIR__, 2).'/public';
               // e.g /var/www/project/public/my_first_excel_symfony4.xlsx
               $excelFilepath =  $publicDirectory . '/my_mobile_excel_codenameone.xlsx';
               
               // Create the file
               $writer->save($excelFilepath);
        // Return the excel file as an attachment
        $objDateTime = new \DateTime('NOW');
        $dateString = $objDateTime->format('d-m-Y H:i:s');

        $path = dirname(__DIR__, 2).'/public/assets/';

        // set qrcode
        $result = $this->builder
            ->data($url)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(400)
            ->margin(10)
            ->labelText($dateString)
            ->labelAlignment(new LabelAlignmentCenter())
            ->labelMargin(new Margin(15, 5, 5, 5))
            ->backgroundColor(new Color(221, 158, 3))
            ->build()
        ;


        //Save img png
        $result->saveToFile($path.$namePng.'.png');

        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
     }

    /**
     * @Route("/mail")
     */
    
     public function mailer(\Swift_Mailer $mailer)
{          $em = $this->getDoctrine()->getManager();
    $materiels = $em->getRepository(materiel::class)->findAll();      
    foreach($materiels as $materiel) {
    $database = [$materiel->getNom(),$materiel->getPrix(),$materiel->getDescmat()]; 
    $namePng =implode(' ',[$materiel->getNom(),$materiel->getPrix(),$materiel->getDescmat()]);
} 
$message = (new \Swift_Message('notification'))

->setFrom('monemehamila@gmail.com')
->setTo('monaem.hmila@esprit.tn')
->setBody($namePng )


;

$mailer->send($message);
return $this->render('back/show_materiel.html.twig', [
    "materiels" => $materiels,
]);
}


}