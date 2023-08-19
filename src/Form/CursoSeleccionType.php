<?php

namespace App\Form;


use App\Entity\Curso;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CursoSeleccionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $cursos = $options['cursos'];
        $builder
            ->add('cursosSeleccionados', ChoiceType::class,[
                'choices' => $cursos,
                'expanded' => true,
                'multiple' => true,
                'mapped' => false,

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'cursos' => []// Configure your form options here
        ]);
    }
}
