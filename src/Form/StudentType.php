<?php

namespace App\Form;

use App\Entity\Club;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nsc')
            ->add('email')
            ->add('classroom')

          ->add('clubs',EntityType::class,[
                'class'=> Club::class,
                'choice_label'=>'ref',
                'label'=>'liste des clubs',
                'multiple'=>true,
                'expanded'=>true, ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
