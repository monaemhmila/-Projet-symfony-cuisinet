<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\LoginType;
use App\Form\RegisterType;
use App\Entity\User;
use App\Repository\UserRepository;

class AuthController extends AbstractController
{
    

    /**
     * @Route("/login", name="app_login")
     */
    public function login(Request $request, UserRepository $repository, FlashyNotifier $flashy): Response
    {
        $user = new User();
        $form=$this->createForm(LoginType::class, $user);
        $form->add('Se connecter', SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $gotUser = $repository->findBy(array('username' => $user->getUsername()));
            if(!empty($gotUser)){
                $gotUser = $gotUser[0];
                if($gotUser->getIsBanned()){
                    $flashy->error('Vous avez été banni !');
                    return $this->redirectToRoute('app_login');
                }
                if($gotUser->getIsActivated()){
                    if(password_verify($user->getPassword(), $gotUser->getPassword())){
                        $session = $request->getSession();
                        $session->set('login', $gotUser->getUsername());
                        $session->set('id', $gotUser->getId());
                        $session->set('fullname', $gotUser->getFullname());
                        $session->set('avatar', $gotUser->getAvatar());
                        $flashy->success('Vous êtes connecté !');
                        return $this->redirectToRoute('HomePage');
                    }
                    else{
                        $flashy->error('Mot de passe incorrect !');
                        return $this->redirectToRoute('app_login');
                    }
                }
                else{
                    $flashy->error('Votre compte n\'est pas activé !');
                    return $this->redirectToRoute('app_login');
                }
            }
            else{
                $flashy->error('Cet utilisateur n\'existe pas !');
                return $this->redirectToRoute('app_login');
            }
        }
        return $this->render('auth/login.html.twig', [
            'controller_name' => 'AuthController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, FlashyNotifier $flashy): Response
    {
        $user = new User();
        $form=$this->createForm(RegisterType::class,$user);
        $form->add('S\'inscrire', SubmitType::class);
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
            $user->setRole('Normal');
            $user->setIsBanned(false);
            $user->setIsActivated(true);
            $user->setActivationCode(md5(uniqid()));
            $em->persist($user);
            $em->flush();
            $flashy->success('Vous êtes inscrit');
            return $this->redirectToRoute('app_login');
        }
        return $this->render('auth/register.html.twig', [
            'controller_name' => 'AuthController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(Request $request, FlashyNotifier $flashy): Response
    {
        $session = $request->getSession();
        $session->clear();
        $flashy->success('Vous êtes déconnecté');
        return $this->redirectToRoute('app_login');
    }
}
