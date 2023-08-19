<?php

namespace App\Form;

use App\Entity\Alumno;
use App\Repository\CursoRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class AlumnoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('apellidoPaterno')
            ->add('apellidoMaterno')
            ->add('dni')
            ->add('cursosSeleccionados', ChoiceType::class, [
                'choices' => array_reduce($options['cursos'], function($choices, $curso){
                    $choices[$curso->getId()] = $curso->getNombre();
                    return $choices;
                },[]),
                'multiple'=> true,
                'expanded' => true,
                'mapped' => false,
            
            ])
            ->add('Registrarse',SubmitType::class)
           
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Alumno::class,
            'cursos' => [],
        ]);
    }
}
