<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LoginType extends AbstractType
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
