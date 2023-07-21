<?php

namespace App\Form;

use App\Entity\ApiRadio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ApiRadioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'label'=>'Nom de la radio : ',
            ])
            ->add('ville',TextType::class,[
                'label'=>'Nom de la Ville ou du Pays : ',
            ])
            ->add('fluxAudio',TextType::class,[
                'label'=>'Lien du flux audio : ',
                'help'=>'( Mettre l\'url avec un https )'
            ])
            ->add('fluxTxt',TextType::class,[
                'label'=>'Lien du flux txt : ',
                'required' => false
            ])
            ->add('codePostal',TextType::class,[
                'label'=>'Code Postal (Si pays laisser vide) : ',
                'required'=> false,
                'empty_data' => '-VIDE-',
            ])
            ->add('rayon',NumberType::class,[
                'label'=>'Rayon en km : ',
                'required'=> false,
                'empty_data' => '15',
            ])
            ->add('imageFile', FileType::class,[
                'label'=>'Upload d\'image de la radio : ',
                'required'=> false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ApiRadio::class,
        ]);
    }
}
