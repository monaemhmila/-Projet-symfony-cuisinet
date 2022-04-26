<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UserAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username',TextType::class,[
                'label'=>'Nom d\'utilisateur',
                'attr'=>[
                    'placeholder'=>'Nom d\'utilisateur',
                ]
            ])
            ->add('password',TextType::class,[
                'label'=>'Mot de passe',
                'attr'=>[
                    'placeholder'=>'Mot de passe',
                ]
            ])
            ->add('fullname',TextType::class,[
                'label'=>'Nom complet',
                'attr'=>[
                    'placeholder'=>'Nom et prénom',
                ]
            ])
            ->add('role',ChoiceType::class,[
                'label'=>'Role',
                'attr'=>[
                    'placeholder'=>'Role',
                ],
                'choices'  => [
                    'Normal' => 'Normal',
                    'Admin' => 'Admin',
                ],
            ])
            ->add('avatar',FileType::class, [
                'label'=>'Avatar',
                'attr'=>[
                    'placeholder'=>'Avatar',
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
