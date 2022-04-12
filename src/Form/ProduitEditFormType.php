<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'label'=>'Nom',
                'attr'=>[
                    'placeholder'=>'Nom',
                ]
            ])
            ->add('description',TextType::class,[
                'label'=>"Description",
                'attr'=>[
                    'placeholder'=>"Description",
                ]
            ])
            ->add('prix',TextType::class,[
                'label'=>"Prix",
                'attr'=>[
                    'placeholder'=>"Prix",
                ]
            ])
            ->add('photo',FileType::class, [
                'mapped'=>false,
                'label'=>'Photo',
                'attr'=>[
                    'placeholder'=>'Photo',
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}