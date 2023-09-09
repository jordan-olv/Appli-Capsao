<?php

namespace App\Form;

use App\Entity\Slider;
use App\Entity\ApiEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

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
            ])
            ->add('link', TextType::class, [
                'label' => 'Lien événement : ',
                'label_attr' => ['class' => 'formVide'],
                'attr' => ['class' => 'formVide'],
                'required' => false
            ])
            ->add('imageFile', FileType::class,[
                'label'=>'Upload d\'image de l\'événement : ',
                'label_attr' => ['class' => 'formVide'],
                'attr' => ['class' => 'formVide'],
                'required'=> false
            ])
            ->add('title', HiddenType::class,[
                'label_attr' => ['class' => 'formVide'],
                'attr' => ['class' => 'formVide'],
                'required' => false
            ])
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
