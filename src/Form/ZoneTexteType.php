<?php

namespace App\Form;

use App\Entity\ZoneTexte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ZoneTexteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',TextType::class,[
                    'required'=> false,
                    'empty_data' => '',
                    'constraints' =>[
                        new Regex([
                            'pattern' => '/^[a-zA-Z0-9\s]*$/',
                            'message' => 'Merci de saisir un titre valide'
                        ])
                    ]
                ])
            ->add('texte',TextareaType::class,[
                    'required'=> false,
                    'empty_data' => '',
                    'constraints' =>[
                        new Regex([
                            'pattern' => '/^[a-zA-Z0-9\s]*$/',
                            'message' => 'Merci de saisir un message valide'
                        ])
                    ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ZoneTexte::class,
        ]);
    }
}
