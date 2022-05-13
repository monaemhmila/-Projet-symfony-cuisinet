<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Livreur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreurType extends AbstractType
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

            ->add('commande', EntityType::class,[

                'class'=> commande::class,
                'choice_label'=>'nom',
                'multiple'=>false,
                'label'=>'Commande'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livreur::class,
        ]);
    }
}
