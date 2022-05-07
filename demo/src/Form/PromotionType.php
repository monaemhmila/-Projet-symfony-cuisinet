<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Promotion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromotionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pourcentage',TextType::class,[
                'label'=>"Pourcentage",
                'attr'=>[
                    'placeholder'=>"Pourcentage",
                ]
            ])

            ->add('produit', EntityType::class,[

                'class'=> Produit::class,
                'choice_label'=>'nom',
                'multiple'=>false,
                'label'=>'Produit'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Promotion::class,
        ]);
    }
}
