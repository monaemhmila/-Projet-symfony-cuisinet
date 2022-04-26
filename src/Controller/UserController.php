<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\UserAddType;
use App\Form\UserEditType;
use App\Entity\User;

class UserController extends AbstractController
{
    /**
     * @route("/dashboard/users", name="AfficherUsers")
     */
    public function AfficherUsers(UserRepository $repository){

        $users=$repository->findAll();
        return $this->render('user/afficher.html.twig',
            ['users'=>$users ]);

    }

    /**
     * @route("/dashboard/users/add", name="AjouterUser")
     */
    function AjouterUser(Request $request){

        $user = new User();
        $form=$this->createForm(UserAddType::class,$user);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file = $user->getAvatar();
            $uploads_directory = $this->getParameter('upload_directory');
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $uploads_directory,
                $fileName
            );
            $user->setAvatar($fileName);
            $em=$this->getDoctrine()->getManager();
            $user->setIsBanned(false);
            $user->setIsActivated(true);
            $user->setActivationCode(md5(uniqid()));
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('AfficherUsers');
        }
        return $this->render('user/ajouter.html.twig',[
            'form'=>$form->createView()
        ]);

    }

    /**
     * @route ("/dashboard/users/edit/{id}",name="ModifierUser")
     */
    function ModifierUser(UserRepository $repository, $id, Request $request){

        $user=$repository->find($id);
        $form=$this->createForm(UserEditType::class, $user);
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $file = $form['avatar']->getData();

            if($file)
            {
                $uploads_directory = $this->getParameter('upload_directory');
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $uploads_directory,
                    $fileName
                );

                $user->setAvatar($fileName);
            }
            else
            {
                $user->setAvatar($user->getAvatar());
            }
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("AfficherUsers");
        }
        return $this->render('user/modifier.html.twig',[
            'form'=>$form->createView()
        ]);

    }

    /**
     * @route("SupprimerUser/{id}",name="SupprimerUser")
     */
    function SupprimerUser($id, UserRepository $repository){
        $user=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('AfficherUsers');

    }

    /**
     * @route("BanUser/{id}",name="BanUser")
     */
    function BanUser($id, UserRepository $repository){
        $em=$this->getDoctrine()->getManager();
        $user=$repository->find($id);
        $user->setIsBanned(true);
        $em->flush();
        return $this->redirectToRoute('AfficherUsers');
    }

    /**
     * @route("UnbanUser/{id}",name="UnbanUser")
     */
    function UnbanUser($id, UserRepository $repository){
        $em=$this->getDoctrine()->getManager();
        $user=$repository->find($id);
        $user->setIsBanned(false);
        $em->flush();
        return $this->redirectToRoute('AfficherUsers');
    }


    
}
