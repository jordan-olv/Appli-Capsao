<?php

namespace App\Form;

use App\Entity\ApiRadio;
use App\Entity\DefaultRadio;
use App\Repository\ApiRadioRepository;
use Symfony\Component\Form\AbstractType;
use App\Repository\DefaultRadioRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RadioDefaultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', EntityType::class, [
                'class' => ApiRadio::class,
                'choice_label'=> 'nom',
                'label' => 'Choisissez la radio par défaut : ',
                'mapped' => false,
                'query_builder' => function(ApiRadioRepository $repo){
                    return $repo->createQueryBuilder('u')->orderBy('u.isDefault','DESC');
                }
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ApiRadio::class,
            'choices' => [],
        ]);
    }
}
