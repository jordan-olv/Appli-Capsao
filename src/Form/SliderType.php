<?php

namespace App\Form;

use App\Entity\Slider;
use App\Entity\ApiEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SliderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', EntityType::class, [
                'label' => 'Choix d\'événement : ',
                'class' => ApiEvent::class,
                'choice_label'=> 'title',
                'mapped' => false
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Slider::class,
            'choices' => [],
        ]);

    }
}
