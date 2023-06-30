<?php

namespace App\Form;

use App\Entity\ApiRadio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ApiRadioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('ville')
            ->add('fluxAudio')
            ->add('fluxTxt')
            ->add('codePostal',TextType::class,[
                'required'=> false,
                'empty_data' => '-VIDE-',
            ])
            ->add('rayon',NumberType::class,[
                'required'=> false,
                'empty_data' => '15',
            ])
            ->add('path');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ApiRadio::class,
        ]);
    }
}
