<?php

namespace App\Form;

use App\Entity\EventFluxRss;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ApiFluxRssType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('link',TextType::class,[
                'label' => 'Lien du flux événement : ',
                'constraints' =>[
                    new Regex([
                        'pattern' => '/^(http|https):\/\/[a-zA-Z0-9]*$/',
                        'message' => 'Merci de saisir un lien valide'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EventFluxRss::class,
        ]);
    }
}
